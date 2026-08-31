<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CheckoutEvent;
use App\Models\AbandonedCart;
use App\Models\Order;
use Illuminate\Support\Facades\DB;


class ShiprocketCheckoutWebhookController extends Controller
{
    public function handle(Request $request)
    {
        DB::table('tests')->insert([
            'payload' => json_encode($request->all()),
        ]);
        $payload = $request->all();
        
        return response()->json(['status' => true], 200);

        // Save every event first
        CheckoutEvent::create([
            'event_type' => $payload['event_type'] ?? $payload['type'] ?? 'unknown',
            'payload' => $payload,
        ]);

        $event = $payload['event_type'] ?? $payload['type'] ?? '';

        if (strtolower($event) === 'abandon_cart') {

            AbandonedCart::updateOrCreate(
                [
                    'cart_token' => $payload['cart_token'] ?? null,
                ],
                [
                    'name' => $payload['customer']['name'] ?? null,
                    'phone' => $payload['customer']['phone'] ?? null,
                    'email' => $payload['customer']['email'] ?? null,
                    'cart_data' => $payload,
                ]
            );
        }

        if (in_array(strtolower($event), ['order_created', 'real_time'])) {

            Order::updateOrCreate(
                [
                    'order_number' => $payload['order_number'] ?? null,
                ],
                [
                    'customer_name' => $payload['customer']['name'] ?? null,
                    'phone' => $payload['customer']['phone'] ?? null,
                    'email' => $payload['customer']['email'] ?? null,
                    'total' => $payload['total'] ?? 0,
                    'shiprocket_data' => $payload,
                ]
            );
        }

        return response()->json(['status' => true], 200);
    }
}