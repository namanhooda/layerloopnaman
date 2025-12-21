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
        $response = Http::withHeaders(self::getHeaders())
            ->get('https://ship.nimbuspost.com/api/orders', $params);

        $dataorder = $response->json();


        $shipments = Http::withHeaders(self::getHeaders())
        ->get('https://ship.nimbuspost.com/api/shipments', $params);

        $dataShipments = $shipments->json();




        foreach ($dataShipments['data'] as $shipmentOrder) {

            $code = 'LLORD' . str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

            $orderId = $shipmentOrder['order_id']; // real NimbusPost order ID

            $responseOrder = Http::withHeaders(self::getHeaders())
                ->get("https://ship.nimbuspost.com/api/orders/{$orderId}");

            $getorder = $responseOrder->json();
            $shipOrder = $getorder['data'];

            $shipmentId = $shipOrder['id'];

            // ✅ Parse order date safely
            $createdAt = !empty($shipOrder['order_date'])
                ? Carbon::parse($shipOrder['order_date'])
                : now();

            // ✅ Find or create address (avoid duplicates)
            $address = Address::firstOrCreate(
                [
                    'phone' => $shipOrder['shipping_phone'],
                ],
                [
                    'user_id' => null,
                    'first_name' => $shipOrder['shipping_fname'] ?? '',
                    'last_name' => $shipOrder['shipping_lname'] ?? '',
                    'country' => $shipOrder['shipping_country'] ?? 'India',
                    'address_line1' => $shipOrder['shipping_address'] ?? 'India',
                    'city'    => $shipOrder['shipping_city'],
                    'state'   => $shipOrder['shipping_state'],
                    'zip'     => $shipOrder['shipping_zip'],
                    'email'   => null,
                ]
            );

            // ✅ Store or update order (NO DUPLICATES)
            Order::updateOrCreate(
                [
                    'shipment_id' => $shipmentId, // 👈 duplicacy check
                ],
                [
                    'order_code'       => $shipOrder['order_number'], // stable
                    'status'           => $shipmentOrder['status'],
                    'payment_mod'      => $shipOrder['payment_method'],
                    'total'            => $shipOrder['order_amount'],
                    'created_at'       => $createdAt,
                    'address_id'       => $address->id,
                    'shipping_charges' => 0,
                    'items'            => json_encode($shipOrder['products']),
                    'raw_response'     => json_encode($shipOrder),
                    'order_from'     => 'NimbusPost',
                ]
            );
        }

       


        if (!$response->successful()) {
            Log::error('NimbusPost Fetch Orders Failed', [
                'status' => $response->status(),
                'response' => $response->body(),
            ]);

            return null;
        }

        return $response->json();
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
public static function createOrder(array $orderPayload): array
{
    $token = Cache::get('nimbus_token') ?? self::loginAndStoreToken();

    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $token,   // ✅ THIS IS REQUIRED
        'Accept'        => 'application/json',
        'Content-Type'  => 'application/json',
    ])->post('https://api.nimbuspost.com/v1/shipments', $orderPayload);

    $data = $response->json();

    if (!$response->successful()) {
        logger()->error('NimbusPost Error', [
            'status'   => $response->status(),
            'response' => $data,
        ]);
    }

    return $data;
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
