<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ShiprocketService;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Address;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class OrderController extends Controller
{
public function index(Request $request)
{
    if ($request->ajax()) {

    $query = Order::with('user')
        ->orderByDesc('order_date')
        ->orderByDesc('created_at');

    return DataTables::eloquent($query)
        ->addIndexColumn()

        ->addColumn('order_code', fn ($o) =>
            '<a href="'.route('admin.orders.show', $o->id).'">'.e($o->order_code).'</a>'
        )

        ->addColumn('phone', fn ($o) => $o->user?->phone ?? 'N/A')
        ->addColumn('email', fn ($o) => $o->user?->email ?? 'N/A')

        ->addColumn('order_date', fn ($o) =>
            $o->order_date?->format('d F Y') ?? 'N/A'
        )

        ->editColumn('payment_mod', fn ($o) => $o->payment_mod ?? 'N/A')
        ->addColumn('total', fn ($o) => $o->total ?? 'N/A')
        ->addColumn('shipment_from', fn ($o) => $o->shipment_from ?? 'Website')

        ->editColumn('status', function ($o) {
            $s = strtoupper($o->status ?? '');
            $c = match (true) {
                in_array($s, ['CANCELLED','CANCELED']) => 'bg-danger',
                $s === 'DELIVERED' => 'bg-success',
                default => 'bg-primary'
            };
            return "<span class='badge {$c}'>{$s}</span>";
        })

        // 🔍 SEARCH FIX
        ->filterColumn('phone', fn ($q,$k) =>
            $q->whereHas('user', fn ($uq) => $uq->where('phone','like',"%{$k}%"))
        )
        ->filterColumn('email', fn ($q,$k) =>
            $q->whereHas('user', fn ($uq) => $uq->where('email','like',"%{$k}%"))
        )
        ->filterColumn('order_code', fn ($q,$k) =>
            $q->where('order_code','like',"%{$k}%")
        )
        ->filterColumn('shipment_from', fn ($q,$k) =>
            $q->where('shipment_from','like',"%{$k}%")
        )

        ->rawColumns(['order_code','status'])
        ->make(true);
}


    $totalOrders = Order::query();

    $orderscount = [
        'delivered' => (clone $totalOrders)->where('status', 'Delivered')->count(),
        'cancelled' => (clone $totalOrders)->where('status', 'cancelled')->count(),
        'pending'   => (clone $totalOrders)->whereNotIn('status', ['rto','cancelled','delivered'])->count(),
        'rto' => (clone $totalOrders)->where('status', 'like', '%rto%')->count(),
    ];

    return view('admin.orders.index', compact('orderscount'));
}

    public function show(Request $request, $id)
    {
        $order = Order::find($id); 
        $orderItems = OrderItem::where('order_id', $id)->get(); 
        $user = User::find($order->user_id); 
        $address = Address::find($order->address_id); 
        return view('admin.orders.show', compact('order','orderItems','user','address'));
    }

    public function create(Request $request)
    {
        return view('admin.orders.create');
    }

    public function store(Request $request)
{

    $request->validate([
        'shipment_from'    => 'required|string|max:255',
        'sub_total'        => 'required|numeric|min:0',
        'shipping_charges' => 'required|numeric|min:0',
        'total'            => 'required|numeric|min:0',
        'status'           => 'required',
        'order_date'       => 'required|date',
        'payment_status'   => 'required',
        'payment_mode'     => 'required',
    ]);

        $code = 'LLORD' . str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
    $address = Address::find($request->address_id);
    $user = User::find($address->user_id);
    $user_id = $user->id ?? null;

    Order::create([
        'order_code'    => $code,
        'shipment_from'    => $request->shipment_from,
        'sub_total'        => $request->sub_total,
        'shipping_charges' => $request->shipping_charges,
        'total'            => $request->total,
        'status'           => $request->status,
        'order_date'       => $request->order_date,
        'payment_status'   => $request->payment_status,
        'payment_mode'     => $request->payment_mode,
        'address_id'       => $request->address_id,
    ]);

    return redirect()->route('admin.orders.index')
        ->with('success', 'Order created successfully');
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
  
public function search(Request $request)
{
    $search = $request->search;

    $addresses = Address::query()
        ->when($search, function ($query) use ($search) {
            $query->where('first_name', 'like', "%$search%")
                  ->orWhere('last_name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%");
        })
        ->limit(20)
        ->get(['id', 'first_name', 'last_name', 'email', 'phone']);

    return response()->json($addresses);
}



public function addressStore(Request $request)
{
    $request->validate([
        'first_name'     => 'required',
        'last_name'      => 'nullable',
        'country'        => 'required',
        'address_line1'  => 'required',
        'city'           => 'required',
        'state'          => 'required',
        'zip'            => 'required',
        'email'          => 'nullable|email',
        'phone'          => 'nullable'
    ]);

    // ❗ Ensure at least one exists
    if (!$request->email && !$request->phone) {
        return response()->json([
            'status' => false,
            'message' => 'Email or Phone is required'
        ], 422);
    }

    // 🔍 Find user
    $user = User::query()
        ->when($request->email, function ($q) use ($request) {
            $q->where('email', $request->email);
        })
        ->when($request->phone, function ($q) use ($request) {
            $q->orWhere('phone', $request->phone);
        })
        ->first();

    // ✅ If user not found → create new user
    if (!$user) {

        $user = User::create([
            'name'     => $request->first_name . ' ' . $request->last_name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make(Str::random(8)), // random password
        ]);
    }

    // ✅ Create Address with user_id
    $data = $request->all();
    $data['user_id'] = $user->id;

    $address = Address::create($data);


    return response()->json($address);
}

public function searchProdct(Request $request)
{
    $products = Product::where('name', 'like', "%{$request->search}%")
        ->limit(20)
        ->get(['id', 'name', 'price', 'featured_image']);

    return response()->json($products);
}

}
