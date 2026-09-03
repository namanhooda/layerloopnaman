<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use App\Models\Cart;
use App\Models\User;
use App\Models\Address;
use App\Models\Product;
use App\Models\Order;
use App\Models\Coupon;
use Illuminate\Support\Facades\Session;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Razorpay\Api\Api; 
use Illuminate\Support\Facades\Validator;
use App\Mail\OrderPlacedNotification;
use Illuminate\Support\Facades\Mail;
use App\Helpers\ShiprocketHelper;


class CheckoutController extends Controller
{
    //

    public function checkout(Request $request)
    {
        $orderId = $request->oid;

        if (!$orderId) {
            abort(404);
        }

        $apiKey = env('SHIPROCKET_CHECKOUT_KEY');
        $apiSecret = env('SHIPROCKET_CHECKOUT_SECRET');

        $payload = [
            'order_id' => $orderId,
            'timestamp' => now()->toIso8601ZuluString(), // e.g. 2026-07-16T08:30:25Z
        ];

        // IMPORTANT: Sign the JSON payload
        $jsonPayload = json_encode($payload, JSON_UNESCAPED_SLASHES);

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
                'https://checkout-api.shiprocket.com/api/v1/custom-platform-order/details',
                $payload
            );


        if (!$response->successful()) {
            return response()->json([
                'status' => false,
                'http_status' => $response->status(),
                'payload' => $payload,
                'json_payload' => $jsonPayload,
                'signature' => $signature,
                'response' => $response->json(),
                'raw' => $response->body(),
            ]);
        }


        $data = $response->json();

        if (!isset($data['ok']) || !$data['ok']) {
            return response()->json([
                'status' => false,
                'message' => 'Unable to create order.',
                'response' => $data
            ], 422);
        }

        $orderData = $data['result'];

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

            session()->forget('coupon');
            $order = $newOrder;


            DB::commit();
                Mail::to('shop.layerloop@gmail.com')
                    ->queue(new OrderPlacedNotification($order));
                return redirect()
                ->route('order.success', ['code' => $order->order_code])
                ->with('success', 'Order placed successfully!');


        } catch (\Throwable $e) {

            DB::rollBack();

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

    }

    public function generateCartToken(Request $request)
    {
        $userId = auth()->id();

        $systemId = null;

        if (!$userId) {
            $rawIdentifier = $request->userAgent() . '|' . $request->ip();
            $systemId = hash('sha256', $rawIdentifier);
        }

        $cartItems = Cart::with('product')
            ->where(function ($query) use ($userId, $systemId) {

                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('system_id', $systemId);
                }

            })
            ->get();

        if ($cartItems->isEmpty()) {

            return response()->json([
                'success' => false,
                'message' => 'Cart is empty.'
            ]);

        }

        $items = [];

        foreach ($cartItems as $cart) {

            $items[] = [
                "variant_id" => "808185" . $cart->product_id,
                "quantity"   => $cart->quantity
            ];

        }

        $apiKey = env('SHIPROCKET_CHECKOUT_KEY');
        $apiSecret = env('SHIPROCKET_CHECKOUT_SECRET');

        $payload = [
            "cart_data" => [
                "items" => $items,
                "mobile_app" => false
            ],
            "redirect_url" => url('/checkout'),
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


    public function generateToken()
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->post('https://apiv2.shiprocket.in/v1/external/auth/login', [
            'email' => 'jatinsangwan779@gmail.com',
            'password' => 't#fJpXuu7C4@sO1joaJVAuV3oLv#h!bk',
        ]);

        $data = $response->json();

        if (isset($data['token'])) {
            return response()->json([
                'token' => $data['token']
            ]);
        }

        return response()->json([
            'error' => 'Token not generated',
            'response' => $data
        ], 500);

        dd($data); // debug again

    }


    public function generateCheckoutToken(Request $request)
    {
        $cart = $request->cart;

        $body = [
            "cart_data" => [
                "items" => $cart
            ],
            "redirect_url" => route('checkout.success'),
            "timestamp" => now()->toISOString()
        ];

        $payload = json_encode($body);

        $hmac = ShiprocketHelper::hmac($payload);

        $response = Http::withHeaders([
            'X-Api-Key' => config('services.shiprocket.key'),
            'X-Api-HMAC-SHA256' => $hmac
        ])->post(config('services.shiprocket.base').'/api/v1/access-token/checkout', $body);

        return $response->json();
    }





    public function placeOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shipping_type' => 'required',
            'shipping_charges' => 'required',
            'payment_method' => 'required',
            'billing_address' => 'required|exists:addresses,id',
        ], [
            'payment_method.required' => 'Please select a Payment Method.',
            'shipping_type.required' => 'Please select a shipping type.',
            'shipping_charges.required' => 'Shipping charges are required.',
            'billing_address.required' => 'Please select a billing address.',
            'billing_address.exists' => 'Selected billing address is invalid.',
        ]);

       if ($validator->fails()) {
            return redirect()->back()
                ->with('error', $validator->errors()->first()) // first error only
                ->withInput();
        }
    
        $userId = auth()->id();
        $systemId = session('system_id');
    
        // Get cart items
        $cartItems = Cart::with('product')
            ->where(function ($query) use ($userId, $systemId) {
                $query->when($userId, fn($q) => $q->where('user_id', $userId))
                      ->when(!$userId && $systemId, fn($q) => $q->where('system_id', $systemId));
            })
            ->get();
    
        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }

        $code = 'LLORD' . str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
    
        
        // Create Order
        $order = new Order();
        $order->user_id = $userId;
        $order->order_code = $code;
        $order->address_id = $request->billing_address;
        $order->shipping_type = $request->shipping_type;
        $order->shipment_from = 'Website';

        // Check if coupon exists in session
        if (Session::has('coupon')) {
            $coupon = Session::get('coupon');

            $order->coupon_applied = 'yes';
            $order->coupon_code = $coupon['code'] ?? null;
            $order->coupon_discount = $coupon['value'] ?? 0;
        }

        $order->shipping_charges = $request->shipping_charges;
        $order->payment_mod = $request->payment_method;
        $order->total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $order->status = 'pending';
        $order->save();
    
        // Create Order Items
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item->product_id,
                'size' => $item->size,
                'quantity'   => $item->quantity,
                'price'      => $item->product->price,
            ]);
        }

        if ($request->payment_method === 'online') {
            // Razorpay order creation

        $order = Order::find(1);

            $totalAmount = $order->total;
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

            $razorpayOrder = $api->order->create([
                'receipt' => 'order_' . $order->id,
                'amount' => $totalAmount * 100, // In paise
                'currency' => 'INR',
                'payment_capture' => 1
            ]);

            // Optionally save Razorpay order ID to database
            $order->razorpay_order_id = $razorpayOrder->id;
            $order->save();

            // Redirect to Razorpay checkout page
            return view('frontend.razorpay', [
                'order' => $order,
                'razorpayOrder' => $razorpayOrder,
                'amount' => $totalAmount,
                'billingAddress' => $request->billing_address,
                'user' => auth()->user(),
                'razorpayKey' => env('RAZORPAY_KEY'),
            ]);
        }


    
        Cart::where(function ($query) use ($userId, $systemId) {
            $query->when($userId, fn($q) => $q->where('user_id', $userId))
                  ->when(!$userId && $systemId, fn($q) => $q->where('system_id', $systemId));
        })->delete();


        Mail::to('shop.layerloop@gmail.com')
            ->queue(new OrderPlacedNotification($order));

        return redirect()
        ->route('order.success', ['code' => $order->order_code])
        ->with('success', 'Order placed successfully!');
    }

    public function verifyPayment(Request $request)
    {
        $paymentId = $request->input('payment_id');
        $orderId = $request->input('order_id');

        $order = Order::findOrFail($orderId);
        $order->payment_id = $paymentId;
        $order->payment_status = 'paid';
        $order->save();

        // Clear cart
        $userId = auth()->id();
        $systemId = session('system_id');
        

        return redirect()->route('order.success')->with('success', 'Payment successful and order placed!');
    }
    public function success(Request $request)
    {
        $order_code = $request->code;
        $order = Order::with(['itemsData.product', 'user', 'address'])
            ->where('order_code', $order_code)
            ->first();

        if (!$order) {
            return redirect()->route('home')->with('error', 'Order not found.');
        }

        return view('frontend.order-success', compact('order'));
    }


    public function getCheckoutToken()
    {
        $payload = [
            "cart_data" => [
                "items" => [
                    [
                        "variant_id" => "1244539923890450",
                        "quantity" => 1
                    ]
                ],
                "custom_attributes" => [
                    "your_key" => "your_value"
                ],
                "mobile_app" => false
            ],
            "redirect_url" => route('checkout.success'),
            "timestamp" => now()->toISOString()
        ];

        // 🔥 FORCE JSON STRING
        $jsonPayload = json_encode($payload, JSON_UNESCAPED_SLASHES);

        // 🔥 HMAC on SAME STRING
        $hmac = base64_encode(hash_hmac(
            'sha256',
            $jsonPayload,
            config('services.shiprocket_checkout.secret'),
            true
        ));

        $response = Http::withHeaders([
            'X-Api-Key' => config('services.shiprocket_checkout.key'),
            'X-Api-HMAC-SHA256' => $hmac,
            'Content-Type' => 'application/json'
        ])->withBody($jsonPayload, 'application/json') // ✅ IMPORTANT
        ->post('https://checkout-api.shiprocket.com/api/v1/access-token/checkout');

        $data = $response->json();

        dd($data);
    }

    public function shiprocketProducts()
    {
        $products = \App\Models\Product::all();

        $data = $products->map(function ($product) {
            return [
                "id" => (string)$product->id,
                "title" => $product->name,
                "variants" => [
                    [
                        "id" => (string)$product->id, // same ID
                        "title" => $product->name,
                        "price" => (string)$product->price,
                        "inventory_quantity" => $product->stock ?? 100
                    ]
                ]
            ];
        });

        return response()->json([
            "data" => $data
        ]);
    }
    public function shiprocketCollections()
    {
        return response()->json([
            "data" => []
        ]);
    }
}
