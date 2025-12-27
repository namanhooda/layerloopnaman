<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\Address;
use App\Models\Order;
use Carbon\Carbon;

class ShiprocketService
{
public static function getToken()
{

        $response = Http::post(
            'https://apiv2.shiprocket.in/v1/external/auth/login',
            [
                'email'    => 'jatinsangwan779@gmail.com',
                'password' => 't#fJpXuu7C4@sO1joaJVAuV3oLv#h!bk',
            ]
        );

        $data = $response->json();

        // dd($data['token']);
        // if (!$response->successful() || empty($data['token'])) {
        //     logger()->error('Shiprocket Auth Failed', [
        //         'status' => $response->status(),
        //         'response' => $data,
        //     ]);

        //     return null;
        // }

        return $data['token'];
}



public static function fetchAndStoreOrders()
{
    $token = self::getToken();
    if (!$token) {
        return ['success' => false, 'message' => 'Shiprocket authentication failed'];
    }

    $page = 1;
    $perPage = 200;

    do {
        $response = Http::withToken($token)->get(
            'https://apiv2.shiprocket.in/v1/external/orders',
            [
                'page' => $page,
                'per_page' => $perPage,
                'from' => '2023-01-01', // VERY IMPORTANT
                'to' => now()->format('Y-m-d'),
            ]
        );

        $data = $response->json();
        $orders = $data['data'] ?? [];
        // $statuses = collect($orders)->pluck('status');
        foreach ($orders as $shipOrder) {
            self::storeOrder($shipOrder);
        }

        $hasMore = count($orders) === $perPage;
        $page++;

    } while ($hasMore);

    return ['success' => true, 'message' => 'All orders synced successfully'];
}



    public static function createOrder($order)
    {
        $token = self::getToken();

        if (!$token) {
            return [
                'success' => false,
                'message' => 'Shiprocket authentication failed'
            ];
        }

        $items = [];
        foreach ($order->items as $item) {
            $items[] = [
                'name' => $item->name ?? 'test',
                'sku' => $item->sku ?? 'SKU-' . $item->id,
                'units' => $item->quantity,
                'selling_price' => $item->price,
            ];
        }
        $address = Address::find($order->address_id);
        $payload = [
            'order_id' => $order->order_code,
            'order_date' => $order->created_at->format('Y-m-d'),
            'pickup_location' => 'layerloo', 

            'billing_customer_name' => $address->first_name,
            'billing_last_name' => $address->last_name ?: 'Customer',
            'billing_address' => $address->address_line1,
            'billing_city' => $address->city,
            'billing_pincode' => $address->zip,
            'billing_state' => $address->state,
            'billing_country' => 'India',
            'billing_email' => $address->email,
            'billing_phone' => $address->phone,

            'shipping_is_billing' => true,

            'shipping_last_name' => $address->last_name ?: 'Customer',
            'shipping_pincode' => $address->zip,
            'order_items' => $items,

            'payment_method' => $order->payment_method === 'cod' ? 'COD' : 'Prepaid',
            'sub_total' => $order->total,

            'length' => 10,
            'breadth' => 10,
            'height' => 5,
            'weight' => 0.5,
        ];

        $response = Http::withToken($token)
            ->post('https://apiv2.shiprocket.in/v1/external/orders/create/adhoc', $payload);

        dd( $response->json());
    }

private static function storeOrder(array $shipOrder)
{

    $code = 'LLORD' . str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

    $createdAt = !empty($shipOrder['created_at'])
        ? Carbon::createFromFormat('d M Y, h:i A', $shipOrder['created_at'])
        : now();

    $order = Order::where('shipment_order_id', $shipOrder['channel_order_id'])->first();

    $orderCode = $order?->order_code ?? $code;

    $phone = null;

    if (!empty($shipOrder['shipping_phone']) && $shipOrder['shipping_phone'] !== 'xxxxxxxxxx') {
        $phone = $shipOrder['shipping_phone'];
    } elseif (!empty($shipOrder['customer_phone']) && $shipOrder['customer_phone'] !== 'xxxxxxxxxx') {
        $phone = $shipOrder['customer_phone'];
    }

    $email = !empty($shipOrder['customer_email']) ? $shipOrder['customer_email'] : null;

    $user = null;

    if ($phone || $email) {
        $user = \App\Models\User::firstOrCreate(
            [
                'phone' => $phone,
            ],
            [
                'name'     => $shipOrder['customer_name'] ?? 'Guest User',
                'email'    => $email,
                'password' => bcrypt(\Illuminate\Support\Str::random(12)),
            ]
        );
    }

    // ✅ Find or create address
    $address = Address::firstOrCreate(
        [
            'first_name'    => $shipOrder['customer_name'],
            'address_line1' => $shipOrder['customer_address'],
        ],
        [
            'user_id' => $user?->id,
            'country' => $shipOrder['customer_country'],
            'city'    => $shipOrder['customer_city'],
            'state'   => $shipOrder['customer_state'],
            'zip'     => $shipOrder['customer_pincode'],
            'phone'   => $shipOrder['customer_phone'] !== 'xxxxxxxxxx' ? $shipOrder['customer_phone'] : null,
            'email'   => $shipOrder['customer_email'],
        ]
    );

    // ✅ Store / Update Order
    Order::updateOrCreate(
        ['shipment_id' => $shipOrder['id']],
        [
            'order_code'           => $orderCode,
            'shipment_id'          => $shipOrder['id'],
            'shipment_order_id'  => $shipOrder['channel_order_id'],
            'status'               => $shipOrder['status'],
            'payment_mod'          => $shipOrder['payment_method'],
            'total'                => $shipOrder['total'],
            'created_at'           => Carbon::parse($shipOrder['created_at'])->utc(),

            'order_date'           => Carbon::parse($shipOrder['created_at'])->utc(),
            'address_id'           => $address->id,
            'shipping_charges'     => 0,
            'items'                => json_encode($shipOrder['products']),
            'raw_response'         => json_encode($shipOrder),
            'shipment_from'     => 'Shiprocket',
            'user_id' => $user?->id,
        ]
    );
}



}
