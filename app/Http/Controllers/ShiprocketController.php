<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ShiprocketController extends Controller
{

public function checkout()
{
    
    return view('frontend.shiprocket.checkout');
}

public function generateToken(Request $request)
{
    $productId = 808185 .$request->product_id;

    $apiKey = env('SHIPROCKET_CHECKOUT_KEY');
    $apiSecret = env('SHIPROCKET_CHECKOUT_SECRET');


    $payload = [
        "cart_data" => [
            "items" => [
                [
                    "variant_id" => $productId,
                    "quantity" => 1
                ]
            ],
            "custom_attributes" => [
                "your_key" => "your_value"
            ],
            "mobile_app" => false
        ],
        "redirect_url" => url('/order/success'),
        "timestamp" => now()->toIso8601ZuluString()
    ];

    $jsonPayload = json_encode($payload);

    $signature = base64_encode(
        hash_hmac(
            'sha256',
            $jsonPayload,
            $apiSecret,
            true
        )
    );

    $response = Http::withoutVerifying()
        ->withHeaders([
            'X-Api-Key' => $apiKey,
            'X-Api-HMAC-SHA256' => $signature,
            'Content-Type' => 'application/json',
        ])
        ->post(
            'https://checkout-api.shiprocket.com/api/v1/access-token/checkout',
            $payload
        );

    if (!$response->successful()) {
        return response()->json([
            'success' => false,
            'message' => $response->body()
        ], $response->status());
    }

    $result = $response->json();

    return response()->json([
        'success' => true,
        'access_token' => $result['result']['token'],
        'order_id' => $result['result']['data']['order_id'],
        'expires_at' => $result['result']['expires_at'],
    ]);
}


    // public function generateToken(Request $request)
    // {
    //     $response = Http::withHeaders([
    //         'X-Api-Key' => env('SHIPROCKET_API_KEY'),
    //         'Content-Type' => 'application/json'
    //     ])->post('https://apiv2.shiprocket.in/v1/external/checkout/token', [

    //         "amount" => $request->amount,

    //         "currency" => "INR",

    //         "order_id" => $request->order_id,

    //         "customer" => [
    //             "name" => auth()->user()->name,
    //             "email" => auth()->user()->email,
    //             "phone" => auth()->user()->mobile
    //         ]

    //     ]);

    //     return $response->json();
    // }
    public function webhook(Request $request)
{
    Log::info($request->all());

    if($request->payment_status=="SUCCESS")
    {
        Order::where('order_id',$request->order_id)
             ->update([
                'payment_status'=>'Paid'
             ]);
    }
}
}
