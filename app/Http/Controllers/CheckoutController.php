<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use App\Models\Cart;
use App\Models\Address;
use App\Models\Order;
use App\Models\Coupon;
use Illuminate\Support\Facades\Session;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Razorpay\Api\Api; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Mail\OrderPlacedNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use App\Helpers\ShiprocketHelper;


class CheckoutController extends Controller
{
    //



public function generateToken(Request $request)
{


        $userId = auth()->id();
    
        // Use the same method as in 'add()' for guest user tracking
        $systemId = null;
            $rawIdentifier = $request->userAgent() . '|' . $request->ip();
            $systemId = hash('sha256', $rawIdentifier);
        if ($userId && $systemId) {
            // Migrate guest cart items to the logged-in user
            Cart::where('system_id', $systemId)
                ->whereNull('user_id') // only migrate unassigned
                ->update([
                    'user_id' => $userId,
                    'system_id' => null
                ]);
        }
    
        $cartItems = Cart::with('product')
            ->where(function ($query) use ($userId, $systemId) {
                $query->when($userId, fn($q) => $q->where('user_id', $userId))
                      ->when(!$userId && $systemId, fn($q) => $q->where('system_id', $systemId));
            })
            ->get();
            
        if ($cartItems->isEmpty()) {
            return response()->json(['error' => 'Cart empty'], 400);
        }




    $items = [];

    foreach ($cartItems as $cart) {
        $items[] = [
            "variant_id" => (string) $cart->product->shiprocket_variant_id,
            "quantity" => $cart->quantity
        ];
    }

    $body = [
        "cart_data" => ["items" => $items],
        "redirect_url" => route('checkout.success'),
        "timestamp" => now()->toISOString()
    ];

    $payload = json_encode($body);

    $hmac = base64_encode(
        hash_hmac('sha256', $payload, config('services.shiprocket.secret'), true)
    );

    $response = Http::withHeaders([
        'X-Api-Key' => config('services.shiprocket.key'),
        'X-Api-HMAC-SHA256' => $hmac
    ])->post('https://checkout-api.shiprocket.com/api/v1/access-token/checkout', $body);

    return $response->json();
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




    public function checkout()
    {
        $userId = auth()->id();
        $systemId = session('system_id');
    
        $cartItems = Cart::with('product')
            ->where(function ($query) use ($userId, $systemId) {
                $query->when($userId, fn($q) => $q->where('user_id', $userId))
                      ->when(!$userId && $systemId, fn($q) => $q->where('system_id', $systemId));
            })
            ->get();
    
        $addresses = Address::where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return redirect('/')
                ->with('error', 'Your cart is empty.');
        }
    
        return view('frontend.checkout', compact('addresses', 'cartItems'));
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
 public function success($order_code)
{
    $order = Order::with(['itemsData.product', 'user', 'address'])
        ->where('order_code', $order_code)
        ->first();

    if (!$order) {
        return redirect()->route('home')->with('error', 'Order not found.');
    }

    return view('frontend.order-success', compact('order'));
}
}
