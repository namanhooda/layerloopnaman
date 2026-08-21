<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Address;

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
        $shipments = Http::withHeaders(self::getHeaders())
        ->get('https://ship.nimbuspost.com/api/shipments', $params);

        $dataShipments = $shipments->json();
        
        // Safety check
        if (!isset($dataShipments['data'])) {
            return [];
        }

        $fromDate = Carbon::now()->subDays(30)->startOfDay(); // 20 days ago
        $toDate   = Carbon::now()->endOfDay(); // today

        $filtered = collect($dataShipments['data'])->filter(function ($shipment) use ($fromDate, $toDate) {
            if (!isset($shipment['created'])) {
                return false;
            }

            $createdDate = Carbon::parse($shipment['created']);

            return $createdDate->between($fromDate, $toDate);
        })->values(); // reset keys

        foreach ($filtered as $shipmentOrder) {

            $code = 'LLORD' . str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

            $orderId = $shipmentOrder['order_id']; // real NimbusPost order ID

            $responseOrder = Http::withHeaders(self::getHeaders())
                ->get("https://ship.nimbuspost.com/api/orders/{$orderId}");

;

            $getorder = $responseOrder->json();
            $shipOrder = $getorder['data'];
            $order = Order::where('order_code', $shipOrder['order_number'])->first();

            if ($order) {
                $order->update([
                    'shipment_id' => $shipOrder['id'],
                ]);
            }

            $shipmentId = $shipOrder['id'];

            // ✅ Parse order date safely
            $createdAt = !empty($shipOrder['order_date']) ? Carbon::parse($shipOrder['order_date']) : now();

            $order = Order::where('shipment_order_id', $shipOrder['order_number'])->first();

            $orderCode = $order?->order_code ?? $code;
            $user = null;

            if (!empty($shipOrder['shipping_phone'])) {
                $user = \App\Models\User::firstOrCreate(
                    [
                        'phone' => $shipOrder['shipping_phone'],
                    ],
                    [
                        'name'     => trim(($shipOrder['shipping_fname'] ?? '') . ' ' . ($shipOrder['shipping_lname'] ?? '')),
                        'email'    => null,
                        'password' => bcrypt($shipOrder['shipping_phone']), // required if password is not nullable
                    ]
                );
            }


            $address = Address::firstOrCreate(
                [
                    'phone' => $shipOrder['shipping_phone'],
                    'address_line1' => $shipOrder['shipping_address'] ?? 'India',
                ],
                [
                    'user_id'   => $user?->id,
                    'first_name'=> $shipOrder['shipping_fname'] ?? '',
                    'last_name' => $shipOrder['shipping_lname'] ?? '',
                    'country'   => $shipOrder['shipping_country'] ?? 'India',
                    'city'      => $shipOrder['shipping_city'] ?? null,
                    'state'     => $shipOrder['shipping_state'] ?? null,
                    'zip'       => $shipOrder['shipping_zip'] ?? null,
                    'email'     => null,
                ]
            );


            // ✅ Store or update order (NO DUPLICATES)
            Order::updateOrCreate(
                [
                    'shipment_id' => $shipmentId, // 👈 duplicacy check
                ],
                [
                    'order_code'       => $orderCode, // stable
                    'shipment_order_id'=> $shipOrder['order_number'], // stable
                    'status'           => $shipmentOrder['status'],
                    'payment_mod'      => $shipOrder['payment_method'],
                    'total'            => $shipOrder['order_amount'],
                    'created_at'       => Carbon::parse($shipOrder['order_date'])->setTime(12, 0, 0)->utc(),
                    'order_date'       => Carbon::parse($shipOrder['order_date'])->setTime(12, 0, 0)->utc(),
                    'address_id'       => $address->id,
                    'user_id'          => $user?->id,
                    'shipping_charges' => 0,
                    'items'            => json_encode($shipOrder['products']) ?? null,
                    'raw_response'     => json_encode($shipOrder),
                    'shipment_from'    => 'NimbusPost',
                ]
            );
        }

        return "success";
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
        dd('nmn');

        

        $token = Cache::get('nimbus_token') ?? self::loginAndStoreToken();

        $payload = [
            "order_number"     => $order->order_code,
            "shipping_charges" => $order->shipping_charges ?? 0,
            "discount"         => $order->discount ?? 0,
            "cod_charges"      => $order->cod_charges ?? 0,

            "payment_type" => strtolower($order->payment_mod) === 'cod'
                ? 'cod'
                : 'prepaid',

            "order_amount"   => $order->total ?? 0,
            "package_weight" => $order->package_weight ?? 300,
            "package_length" => $order->package_length ?? 10,
            "package_breadth" => $order->package_breadth ?? 10,
            "package_height" => $order->package_height ?? 10,

            "consignee" => [
                "name"      => $order->customer_name ?? 'John nmn',
                "address"   => $order->customer_address ?? '123 Main Street',
                "address_2" => $order->customer_address2 ?? "asd",
                "city"      => $order->customer_city ?? 'rfsadf',
                "state"     => $order->customer_state ?? 'faef',
                "pincode"   => $order->customer_zip ?? '124201',
                "phone"     => $order->customer_phone ?? '8059808185',
            ],

            "pickup" => [
                "warehouse_name" => env('NIMBUS_WAREHOUSE_NAME', 'Layerloop'),
                "name"           => env('NIMBUS_PICKUP_NAME', 'Layerloop'),
                "address"        => env('NIMBUS_PICKUP_ADDRESS', '123 Main Street'),
                "address_2"      => env('NIMBUS_PICKUP_ADDRESS2', 'asd'),
                "city"           => env('NIMBUS_PICKUP_CITY', 'rfsadf'),
                "state"          => env('NIMBUS_PICKUP_STATE', 'faef'),
                "pincode"        => env('NIMBUS_PICKUP_PINCODE', '124201'),
                "phone"          => env('NIMBUS_PICKUP_PHONE', '8059808185'),
            ],

            "order_items" => $order->itemsData->map(function ($item) {
                return [
                    "name"  => $item->product->name ?? 'layerloop',
                    "qty"   => $item->quantity ?? 0,
                    "price" => $item->price ?? 0,
                    "sku"   => $item->sku ?? '',
                ];
            })->values()->toArray(),
        ];

        return Http::withHeaders([
            'Authorization' => 'Bearer '.$token,
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
        ])->post(
            'https://api.nimbuspost.com/v1/shipments',
            $payload
        )->json();
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
