<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ShiprocketService;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Order;
use App\Models\User;
use App\Models\Address;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $order = Order::with('user')->get(); // eager load roles

            return DataTables::of($order)
                ->addIndexColumn()
                ->addColumn('order_code', function ($order) {
                    return $order->order_code ?? 'N/A';
                })
                ->addColumn('phone', function ($order) {
                    return $order->user->phone ?? 'N/A';
                })
                ->addColumn('email', function ($order) {
                    return $order->user->email ?? 'N/A';
                })
                ->addColumn('total', function ($order) {
                    return $order->total ?? 'N/A';
                })
                ->editColumn('status', function ($order) {

                    $status = trim($order->status ?? 'N/A');
                    $normalized = strtoupper($status); // normalize casing

                    $badgeClass = match (true) {
                        in_array($normalized, ['CANCELLED', 'CANCELED']) => 'badge bg-danger',
                        $normalized === 'DELIVERED'                       => 'badge bg-success',
                        default                                           => 'badge bg-primary',
                    };

                    return '<span class="badge rounded-pill ' . $badgeClass . '">' . e($status) . '</span>';
                })
                ->editColumn('payment_mod', function ($order) {
                    return $order->payment_mod ?? 'N/A';
                })
                ->addColumn('created_at', function ($user) {
                    return $user->created_at;
                })
                ->addColumn('actions', function ($user) {
                    $editUrl = route('admin.orders.show', $user->id);
                
                    $actions = '<div class="d-flex align-items-center">';
                
                    if (auth()->user()->can('users edit')) {
                        $actions .= '<a class="btn btn-icon me-1 edit-user" href="' . $editUrl . '">
                                        <i class="icon-base ti tabler-eye icon-22px"></i>
                                    </a>';
                    }
                
                    $actions .= '</div>';
                
                    return $actions;
                })
                ->rawColumns(['roles', 'actions','order_code','payment_mod','status'])
                ->make(true);
        }
        $totalOrders = Order::query();

        $orderscount = [
            'delivered' => (clone $totalOrders)->where('status', 'Delivered')->count(),
            'cancelled' => (clone $totalOrders)->where('status', 'CANCELED')->count(),
        ];


        return view('admin.orders.index');
    }
    public function show(Request $request, $id)
    {
        $order = Order::find($id); 
        $orderItems = OrderItem::where('order_id', $id)->get(); 
        $user = User::find($order->user_id); 
        $address = Address::find($order->address_id); 
        return view('admin.orders.show', compact('order','orderItems','user','address'));
    }



    public function createShipment(Order $order, $id)
    {

        $order = Order::find($id);

        // if ($order->shiprocket_order_id) {
        //     return response()->json([
        //         'message' => 'Shipment already created'
        //     ], 422);
        // }


        $page = 1;

        $response = \App\Services\NimbusPostService::fetchNimbusOrders([
            'page'      => 1,
            'per_page'  => 50,
            'from_date' => '2024-01-01',
            'to_date'   => '2024-12-31',
        ]);
        dd($response);
        // $result = ShiprocketService::fetchAndStoreOrders();

        // Optional: allow only paid orders
        // if ($order->payment_status !== 'paid') {
        //     return response()->json([
        //         'message' => 'Order payment not completed'
        //     ], 422);
        // }

        $orderPayload = [
            "customer_name"    => "John Doe",
            "customer_email"   => "john@example.com",
            "customer_phone"   => "9999999999",
            "customer_address" => "123 Main Street",
            "customer_city"    => "Delhi",
            "customer_state"   => "Delhi",
            "customer_country" => "IN",
            "customer_zip"     => "110001",
            "items" => [
                [
                    "name"     => "Product 1",
                    "quantity" => 1,
                    "price"    => 500
                ]
            ],
            "payment_method" => "prepaid", // or cod
            "courier" => "DHL"
        ];

        $response = \App\Services\NimbusPostService::createOrder($orderPayload);

        dd($response);



        $result = \App\Services\NimbusPostService::createOrder($order);



        dd('nmn');

        $response = ShiprocketService::createOrder($order);

        if (!empty($response['order_id'])) {

            $order->update([
                'shiprocket_order_id'    => $response['order_id'],
                'shiprocket_shipment_id' => $response['shipment_id'],
                'status' => 'Shipped',
            ]);

            return response()->json([
                'message' => 'Shipment created successfully'
            ]);
        }

        return response()->json([
            'message' => $response['message'] ?? 'Shiprocket error'
        ], 500);
    }

}
