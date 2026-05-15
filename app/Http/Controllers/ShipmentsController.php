<?php

namespace App\Http\Controllers;
use App\Services\ShiprocketService;
use Yajra\DataTables\Facades\DataTables;
use App\Jobs\FetchNimbusShipmentsJob;
use App\Models\Order;
use App\Models\User;
use App\Models\Address;
use App\Models\OrderItem;
use Carbon\Carbon;

use Illuminate\Http\Request;

class ShipmentsController extends Controller
{
    //


public function fetchShipmentsNimbus(Order $order)
{
    // $fromDate = Carbon::now()->subDays(10)->format('Y-m-d');
    // $toDate   = Carbon::now()->format('Y-m-d');

    // $response = \App\Services\NimbusPostService::fetchNimbusOrders([
    //     'page'      => 1,
    //     'per_page'  => 200,
    //     'from_date' => $fromDate,
    //     'to_date'   => $toDate,
    // ]);

    // return redirect()->back()->with('success', 'Last 45 days shipments fetched successfully!');


    FetchNimbusShipmentsJob::dispatch();

    return back()->with('success', 'Shipments sync started in background!');
}
    public function fetchShipmentsShiorocket(Order $order)
    {
        $result = ShiprocketService::fetchAndStoreOrders();

            return redirect()->back()->with('success', 'Shipments fetch successfully!');
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
