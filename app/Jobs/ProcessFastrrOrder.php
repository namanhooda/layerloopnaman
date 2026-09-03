<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProcessFastrrOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 5;

    public $backoff = [10, 20, 30, 60];

    protected $cartId;

    public function __construct($cartId)
    {
        $this->cartId = $cartId;
    }

    public function handle()
    {
        $orderId = $this->cartId;

        $timestamp = now()->utc()->toIso8601ZuluString();

        $apiKey = env('SHIPROCKET_CHECKOUT_KEY');
        $apiSecret = env('SHIPROCKET_CHECKOUT_SECRET');

        $payload = [
            'order_id' => $orderId,
            'timestamp' => $timestamp,
        ];

        $jsonPayload = json_encode(
            $payload,
            JSON_UNESCAPED_SLASHES
        );

        $signature = base64_encode(
            hash_hmac(
                'sha256',
                $jsonPayload,
                $apiSecret,
                true
            )
        );

        $response = Http::timeout(15)
            ->withoutVerifying()
            ->withHeaders([
                'X-Api-Key' => $apiKey,
                'X-Api-HMAC-SHA256' => $signature,
                'Content-Type' => 'application/json',
            ])
            ->withBody(
                $jsonPayload,
                'application/json'
            )
            ->post(
                'https://checkout-api.shiprocket.com/api/v1/custom-platform-order/details'
            );

        Log::info('Fastrr details API response', [
            'cart_id' => $orderId,
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

        if (!$response->successful()) {
            throw new \Exception(
                'Fastrr details API error: ' . $response->body()
            );
        }

        $json = $response->json();

        $orderData = $json['result'] ?? null;

        /*
        |--------------------------------------------------------------------------
        | Details not ready yet
        |--------------------------------------------------------------------------
        */

        if (empty($orderData)) {

            Log::warning('Fastrr order details not ready', [
                'cart_id' => $orderId,
                'response' => $json,
            ]);

            throw new \Exception(
                'Fastrr order details not available yet.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Full order is available
        |--------------------------------------------------------------------------
        */

        $this->createOrder($orderData);
    }


    private function createOrder(array $orderData)
    { 
        DB::beginTransaction();

        try {
            $phone = $orderData['phone']
    ?? $orderData['shipping_address']['phone']
    ?? null;

$user = User::where('phone', $phone)->first();

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
            DB::table('tests')->insert([
                            'payload' => "Order created",
                        ]);
                Mail::to('shop.layerloop@gmail.com')
                    ->queue(new OrderPlacedNotification($order));


        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Checkout Error', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTraceAsString(),
                'cart_id' => $this->cartId,
            ]);

            throw $e;
        }

    }
}