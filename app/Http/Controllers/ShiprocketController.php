<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ShiprocketController extends Controller
{
    public function generateToken(Request $request)
    {
        $response = Http::withHeaders([
            'X-Api-Key' => env('SHIPROCKET_API_KEY'),
            'Content-Type' => 'application/json'
        ])->post('https://apiv2.shiprocket.in/v1/external/checkout/token', [

            "amount" => $request->amount,

            "currency" => "INR",

            "order_id" => $request->order_id,

            "customer" => [
                "name" => auth()->user()->name,
                "email" => auth()->user()->email,
                "phone" => auth()->user()->mobile
            ]

        ]);

        return $response->json();
    }
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
