<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CheckoutEvent;
use App\Models\AbandonedCart;
use App\Mail\OrderPlacedNotification;
use Illuminate\Support\Facades\Mail;
use App\Models\Order;
use App\Models\Cart;
use App\Models\User;
use App\Models\Address;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;


class ShiprocketCheckoutWebhookController extends Controller
{
  public function handle(Request $request)
{
    // Get cart_id directly from the webhook JSON
    $orderId = $request->input('cart_id');

    // Store complete webhook payload for debugging
    
            DB::table('tests')->insert([
            'payload' => $orderId,
            ]);
        if (!$orderId) {
            DB::table('tests')->insert([
            'payload' => "id not found in webhook payload.",
            ]);
        }


        $timestamp = now()->utc()->toIso8601ZuluString();

        $apiKey = env('SHIPROCKET_CHECKOUT_KEY');
        $apiSecret = env('SHIPROCKET_CHECKOUT_SECRET');

        $payload = [
            'order_id'  => $orderId,
            'timestamp' => $timestamp,
        ];

        // Convert the exact payload to JSON
        $jsonPayload = json_encode(
            $payload,
            JSON_UNESCAPED_SLASHES
        );

        // Generate HMAC
        $signature = base64_encode(
            hash_hmac(
                'sha256',
                $jsonPayload,
                $apiSecret,
                true
            )
        );

        // Send EXACTLY the same JSON that was signed
        $response = Http::withoutVerifying()
            ->withHeaders([
                'X-Api-Key'         => $apiKey,
                'X-Api-HMAC-SHA256' => $signature,
                'Content-Type'      => 'application/json',
            ])
            ->withBody($jsonPayload, 'application/json')
            ->post(
                'https://checkout-api.shiprocket.com/api/v1/custom-platform-order/details'
            );

            $orderData = $response->json()['result'] ?? [];

            DB::table('tests')->insert([
            'payload' => $orderData,
            ]);

        DB::beginTransaction();

        try {
            $user = User::where('phone', $orderData['phone'])->first();

            if (!$user) {

                $user = User::create([
                    'name' => trim(
                        ($orderData['shipping_address']['first_name'] ?? '') . ' ' .
                        ($orderData['shipping_address']['last_name'] ?? '')
                    ),
                    'email' => $orderData['email'] ?? null,
                    'phone' => $orderData['phone'] ?? null,
                    'password' => Hash::make(Str::random(12)),
                ]);
            }

            $shippingAddress = Address::updateOrCreate(

                [
                    'user_id' => $user->id
                ],

                [
                    'first_name'    => $orderData['shipping_address']['first_name'] ?? '',
                    'last_name'     => $orderData['shipping_address']['last_name'] ?? '',
                    'email'         => $orderData['shipping_address']['email'] ?? '',
                    'phone'         => $orderData['shipping_address']['phone'] ?? '',
                    'address_line1' => $orderData['shipping_address']['line1'] ?? '',
                    'address_line2' => $orderData['shipping_address']['line2'] ?? '',
                    'city'          => $orderData['shipping_address']['city'] ?? '',
                    'state'         => $orderData['shipping_address']['state'] ?? '',
                    'country'       => $orderData['shipping_address']['country'] ?? 'India',
                    'zip'           => $orderData['shipping_address']['pincode'] ?? '',
                ]
            );
            $code = 'LLORD' . str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

            $newOrder = new Order();

            $newOrder->user_id = $user->id;
            $newOrder->order_code = $code;
            $newOrder->address_id = $shippingAddress->id;

            $newOrder->shipment_from = 'Website';
            $newOrder->shipping_type = $orderData['shipping_plan'] ?? 'Standard';

            $newOrder->payment_mod = $orderData['payment_type'] ?? '';
            $newOrder->payment_status = $orderData['payment_status'] ?? 'Pending';

            $newOrder->status = 'pending';

            $newOrder->shipping_charges = $orderData['shipping_charges'] ?? 0;
            $newOrder->cod_charges = $orderData['cod_charges'] ?? 0;

            $newOrder->sub_total = $orderData['subtotal_price'] ?? 0;
            $newOrder->discount = $orderData['total_discount'] ?? 0;
            $newOrder->coupon_discount = $orderData['coupon_discount'] ?? 0;

            $newOrder->total = $orderData['total_amount_payable'] ?? 0;

            $newOrder->coupon_code = $orderData['coupon_codes'][0] ?? null;
            if($orderData['coupon_discount']){
                $newOrder->coupon_applied = 'yes';
            }

            $newOrder->fastrr_order_id = $orderData['fastrr_order_id'] ?? null;
            $newOrder->shiprocket_checkout_id = $orderData['order_id'] ?? null;
            $newOrder->platform_order_id = $orderData['platform_order_id'] ?? null;
            $newOrder->edd = $orderData['edd'] ?? null;
            $newOrder->rto_prediction = $orderData['rto_prediction'] ?? null;

            $newOrder->save();

            /*
            |--------------------------------------------------------------------------
            | Order Items
            |--------------------------------------------------------------------------
            */

            foreach ($orderData['cart_data']['items'] as $item) {
                $variantId = str_replace('808185', '', (string) $item['variant_id']);
                $variant = Product::find($variantId);
                $orderItem = OrderItem::create([
                    'order_id' => $newOrder->id,
                    'product_id' => $variant->id ?? null,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'size' => $variant->size ?? null,
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Clear Cart
            |--------------------------------------------------------------------------
            */

            Cart::where('user_id', $user->id)->delete();

            /*
            |--------------------------------------------------------------------------
            | Remove Coupon
            |--------------------------------------------------------------------------
            */
            $order = $newOrder;


            DB::commit();

                Mail::to('shop.layerloop@gmail.com')
                    ->queue(new OrderPlacedNotification($order));
                    dd('Email sent to shop.layerloop@gmail.com');


        } catch (\Throwable $e) {

            DB::rollBack();

            DB::table('tests')->insert([
            'payload' => $e,
            ]);

            \Log::error('Checkout Error', [

                'message' => $e->getMessage(),

                'line' => $e->getLine(),

                'file' => $e->getFile(),

                'trace' => $e->getTraceAsString(),

            ]);

            return response()->json([
                'status' => false,
                'message' => 'Order creation failed.',
                'error' => $e->getMessage()
            ], 500);
        }


        dd($dataship['result']);


    }
}
