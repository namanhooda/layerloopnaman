<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Address;
use DB;

class NimbusPostService
{
    const CACHE_KEY = 'nimbuspost_token';

    /**
     * Get cached NimbusPost token or fetch a new one
     */


    protected static function getHeaders(): array
    {
        return [
            'NP-API-KEY' => env('NIMBUS_API_KEY'),
        ];
    }

    public static function fetchNimbusOrders(array $params = [])
{
    // Increase execution time for this long-running process
    set_time_limit(600); // 5 minutes

    DB::beginTransaction();

    try {

        $shipments = Http::withHeaders(self::getHeaders())
            ->timeout(60)
            ->get('https://ship.nimbuspost.com/api/shipments', $params);

        $dataShipments = $shipments->json();

        // Safety check 
        if (!isset($dataShipments['data'])) {
            DB::commit();
            return [];
        }

        $fromDate = Carbon::now()->subDays(30)->startOfDay();
        $toDate   = Carbon::now()->endOfDay();

        $filtered = collect($dataShipments['data'])->filter(function ($shipment) use ($fromDate, $toDate) {
            if (!isset($shipment['created'])) {
                return false;
            }

            $createdDate = Carbon::parse($shipment['created']);

            return $createdDate->between($fromDate, $toDate);
        })->values();

        foreach ($filtered as $shipmentOrder) {

            $code = 'LLORD' . str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

            $orderId = $shipmentOrder['order_id'];

            $responseOrder = Http::withHeaders(self::getHeaders())
                ->timeout(60)
                ->get("https://ship.nimbuspost.com/api/orders/{$orderId}");

            $getorder = $responseOrder->json();
            $shipOrder = $getorder['data'];

            $order = Order::where('order_code', $shipOrder['order_number'])->first();

            if ($order) {
                $order->update([
                    'shipment_id' => $shipOrder['id'],
                ]);
            }

            $shipmentId = $shipOrder['id'];

            // Parse order date safely
            $createdAt = !empty($shipOrder['order_date'])
                ? Carbon::parse($shipOrder['order_date'])
                : now();

            $order = Order::where(
                'shipment_order_id',
                $shipOrder['order_number']
            )->first();

            $orderCode = $order?->order_code ?? $code;
            $user = null;

            if (!empty($shipOrder['shipping_phone'])) {

                $user = \App\Models\User::firstOrCreate(
                    [
                        'phone' => $shipOrder['shipping_phone'],
                    ],
                    [
                        'name'     => trim(
                            ($shipOrder['shipping_fname'] ?? '') . ' ' .
                            ($shipOrder['shipping_lname'] ?? '')
                        ),
                        'email'    => null,
                        'password' => bcrypt($shipOrder['shipping_phone']),
                    ]
                );
            }

            $address = Address::firstOrCreate(
                [
                    'phone' => $shipOrder['shipping_phone'],
                    'address_line1' => $shipOrder['shipping_address'] ?? 'India',
                ],
                [
                    'user_id'    => $user?->id,
                    'first_name' => $shipOrder['shipping_fname'] ?? '',
                    'last_name'  => $shipOrder['shipping_lname'] ?? '',
                    'country'    => $shipOrder['shipping_country'] ?? 'India',
                    'city'       => $shipOrder['shipping_city'] ?? null,
                    'state'      => $shipOrder['shipping_state'] ?? null,
                    'zip'        => $shipOrder['shipping_zip'] ?? null,
                    'email'      => null,
                ]
            );

            // Store or update order (NO DUPLICATES)
            Order::updateOrCreate(
                [
                    'shipment_id' => $shipmentId,
                ],
                [
                    'order_code'        => $orderCode,
                    'shipment_order_id' => $shipOrder['order_number'],
                    'status'            => $shipmentOrder['status'],
                    'payment_mod'       => $shipOrder['payment_method'],
                    'total'             => $shipOrder['order_amount'],
                    'created_at'        => Carbon::parse($shipOrder['order_date'])
                        ->setTime(12, 0, 0)
                        ->utc(),
                    'order_date'        => Carbon::parse($shipOrder['order_date'])
                        ->setTime(12, 0, 0)
                        ->utc(),
                    'address_id'        => $address->id,
                    'user_id'           => $user?->id,
                    'shipping_charges'  => 0,
                    'items'             => json_encode($shipOrder['products']) ?? null,
                    'raw_response'      => json_encode($shipOrder),
                    'shipment_from'     => 'NimbusPost',
                ]
            );
        }

        DB::commit();

        return "success";

    } catch (\Throwable $e) {

        DB::rollBack();

        \Log::error('Nimbus orders fetch failed', [
            'message' => $e->getMessage(),
            'file'    => $e->getFile(),
            'line'    => $e->getLine(),
            'trace'   => $e->getTraceAsString(),
        ]);

        return [
            'status'  => false,
            'message' => $e->getMessage(),
        ];
    }
}
    public static function getToken(): string
    {
        return Cache::get(self::CACHE_KEY) ?? self::loginAndStoreToken();
    }

    /**
     * Login to NimbusPost and store token in cache
     */
    private static function loginAndStoreToken(): string
    {
        $response = Http::withHeaders([
            'Accept'       => 'application/json',
            'Content-Type' => 'application/json',
            'User-Agent'   => 'Laravel-App/1.0',
        ])->post('https://api.nimbuspost.com/v1/users/login', [
            'email'    => env('NIMBUS_EMAIL'),
            'password' => env('NIMBUS_PASSWORD'),
        ]);

        $data = $response->json();

        if (!$response->successful()) {
            logger()->error('NimbusPost Login Failed', [
                'status' => $response->status(),
                'response' => $data,
            ]);

            throw new \Exception($data['message'] ?? 'NimbusPost login failed with status '.$response->status());
        }

        if (empty($data['data'])) {
            throw new \Exception('NimbusPost token missing in response');
        }

        Cache::put(self::CACHE_KEY, $data['data'], now()->addHours(23));

        return $data['data'];
    }

    /**
     * Create an order in NimbusPost
     */


public static function createB2COrder(Order $order): array
{
    $token = Cache::get('nimbus_token') ?? self::loginAndStoreToken();

    $customerName = trim($order->customer_name);

    $nameParts = preg_split('/\s+/', $customerName, 2);

    $payload = [
        'order_number'   => $order->order_number,
        'payment_method' => strtolower($order->payment_method) == 'cod' ? 'COD' : 'Prepaid',
        'amount'         => $order->order_amount,

        'fname' => $nameParts[0] ?? '',
        'lname' => $nameParts[1] ?? '',

        'address'   => $order->customer_address,
        'address_2' => $order->customer_address2 ?? '',
        'phone'     => $order->customer_phone,
        'city'      => $order->customer_city,
        'state'     => $order->customer_state,
        'country'   => $order->customer_country ?? 'India',
        'pincode'   => $order->customer_zip,

        'weight'   => $order->package_weight ?? 300,
        'length'   => $order->package_length ?? 10,
        'breadth'  => $order->package_breadth ?? 10,
        'height'   => $order->package_height ?? 10,

        'products' => $order->itemsData->map(function ($item) {
            return [
                'name'  => $item->product->name ?? 'null',
                'qty'   => $item->quantity,
                'price' => $item->price,
            ];
        })->values()->toArray(),
    ];

    $response = Http::asForm()
    ->withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
    ])
    ->post('https://ship.nimbuspost.com/api/orders/create', [
        // payload...
    ]);

    if (! $response->successful()) {
        logger()->error('Nimbus B2C Order Error', [
            'status' => $response->status(),
            'body'   => $response->body(),
        ]);
    }

    return $response->json();
}




public static function createOrder(Order $order): array
{
    // 1. Check whether order already exists in NimbusPost
    $fromDate = Carbon::now()->subDays(7)->startOfDay();
    $toDate   = Carbon::now()->endOfDay();

    $responseOrders = Http::withHeaders(self::getHeaders())
        ->get('https://ship.nimbuspost.com/api/orders', [
            'from_date' => $fromDate->format('Y-m-d'),
            'to_date'   => $toDate->format('Y-m-d'),
            'per_page'  => 100,
        ]);

    if (!$responseOrders->successful()) {
        dd([
            'step' => 'Check Existing Orders',
            'http_status' => $responseOrders->status(),
            'response' => $responseOrders->json(),
        ]);
    }

    $existingOrder = collect($responseOrders->json('data', []))
        ->where('order_number', $order->order_code)
        ->where('status', '!=', 'cancelled')
        ->first();

    if ($existingOrder) {

        $order->update([
            'shipment_id'       => $existingOrder['id'] ?? null,
            'status'            => $existingOrder['status'] ?? $order->status,
            'shipment_order_id' => $existingOrder['order_number'] ?? $order->order_code,
        ]);

        return [
            'success' => true,
            'message' => 'Order already exists in NimbusPost',
            'data'    => $existingOrder,
        ];
    }

    // 2. Payment calculation
    $paymentMode = strtolower($order->payment_mod ?? 'prepaid');

    $isPartialPaid = $paymentMode === 'partial_paid';

    $isCod = in_array($paymentMode, [
        'cod',
        'partial_paid',
        'cash_on_delivery',
    ]);

    $orderAmount = $isPartialPaid
        ? ((float) $order->total - ((float) $order->total * 0.30))
        : (float) ($order->total ?? 0);

    // 3. Customer address
    $address = $order->address;

    if (!$address) {
        dd('Customer shipping address not found for order: ' . $order->order_code);
    }

    // 4. Prepare order items
    $items = $order->itemsData->map(function ($item) {

        return [
            'name'            => $item->product->name ?? 'Layerloop Product',
            'qty'             => (int) ($item->quantity ?? 1),
            'price'           => (float) ($item->price ?? 0),
            'sku'             => $item->sku ?? '',
            'hsn'             => $item->hsn ?? '',
            'tax_rate'        => (float) ($item->tax_rate ?? 0),
            'discount_amount' => (float) ($item->discount ?? 0),
        ];

    })->values()->toArray();

    if (empty($items)) {
        dd('No products found for order: ' . $order->order_code);
    }

    // 5. Warehouse ID
    $warehouseId = config('services.nimbuspost.warehouse_id' ?? '68d957f2-33d9-4112-a61f-86640f3db9be');

    // if (empty($warehouseId)) {
    //     dd('NimbusPost warehouse ID is missing. Please configure NIMBUSPOST_WAREHOUSE_ID.');
    // }

    // 6. Prepare V2 API payload
    $payload = [

        'order_number' => $order->order_code,

        'order_type' => 'b2c',

        'payment_mode' => $isCod ? 'cod' : 'prepaid',

        'order_collectable_amount' => (float) ($isCod ? $orderAmount : 0),

        'warehouse_id' => $warehouseId,

        'shipping_address' => [

            'name' => trim(
                ($address->first_name ?? '') . ' ' .
                ($address->last_name ?? '')
            ) ?: 'Layerloop',

            'email'       => $address->email ?? '',
            'address'     => $address->address_line1 ?? '',
            'address_opt' => $address->address_line2 ?? '',
            'pincode'     => (int) ($address->zip ?? 124201),
            'city'        => $address->city ?? 'Beri',
            'state'       => $address->state ?? 'Haryana',
            'country'     => 'India',
            'phone'       => $address->phone ?? '',
        ],

        'items' => $items,

        'package' => [

            // Assuming package_weight is stored in grams
            'weight' => (float) (($order->package_weight ?? 300) / 1000),

            'length' => (float) ($order->package_length ?? 10),

            'width'  => (float) ($order->package_breadth ?? 15),

            'height' => (float) ($order->package_height ?? 15),

        ],

    ];

            $token = Cache::get('nimbus_token') ?? self::loginAndStoreToken();
    // 7. Create order using NimbusPost V2 API
    $response = Http::withHeaders([

                    'Authorization' => 'Bearer '.$token,
                    'Accept'        => 'application/json',
                    'Content-Type'  => 'application/json',

    ])->timeout(60)->post(

        'https://api-v2.nimbuspost.com/v2/orders',

        $payload

    );

    $result = $response->json();

    // 8. Debug API response
    if (!$response->successful()) {
        dd([
            'step' => 'NimbusPost V2 Order Creation',
            'payload' => $payload,
            'http_status' => $response->status(),
            'response' => $result,
        ]);
    }

    if (!is_array($result) || ($result['success'] ?? true) === false || ($result['status'] ?? true) === false) {
        dd([
            'step' => 'NimbusPost API Error',
            'payload' => $payload,
            'response' => $result,
        ]);
    }

    // 9. Extract NimbusPost order details
    $responseData = $result['data'] ?? $result;

    $nimbusOrderId = $responseData['id']
        ?? $responseData['order_id']
        ?? $responseData['orderId']
        ?? null;

    if (!$nimbusOrderId) {
        dd([
            'message' => 'Order API succeeded but NimbusPost order ID was not found.',
            'response' => $result,
        ]);
    }

    // 10. Update Laravel order
    $order->update([
        'shipment_id'       => $nimbusOrderId,
        'shipment_order_id' => $order->order_code,
    ]);

    return [
        'success' => true,
        'message' => 'Order created successfully in NimbusPost without generating AWB.',
        'data' => $result,
    ];
}


    private static function authHeaders(): array
    {
        $token = Cache::get('nimbus_token') ?? self::loginAndStoreToken();

        return [
            'Authorization' => 'Bearer '.$token, // ✅ THIS MUST START WITH Bearer
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
        ];
    }

}
