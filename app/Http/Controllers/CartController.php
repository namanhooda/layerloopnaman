<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

class CartController extends Controller
{
    
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1'
        ]);
    
        $userId = auth()->id();
    
        // Use user agent + IP as fallback system_id (hashed to keep it short and unique-ish)
        if (!$userId) {
            $rawIdentifier = $request->userAgent() . '|' . $request->ip();
            $systemId = hash('sha256', $rawIdentifier); // or just md5() if shorter
        } else {
            $systemId = null; // no need if user is logged in
        }
    
        // Build match condition
        $match = ['product_id' => $request->product_id];
    
        if ($userId) {
            $match['user_id'] = $userId;
        } else {
            $match['system_id'] = $systemId;
        }
    
        // Check if a cart already exists for this user/session
        $existingCartItem = Cart::where(function ($query) use ($userId, $systemId) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('system_id', $systemId);
            }
        })->first();
    
        // Determine cart_id
        if ($existingCartItem) {
            $cartId = $existingCartItem->cart_id;
        } else {
            // Generate new cart ID, e.g., CRT + random 7-digit number
            do {
                $cartId = 'CRT' . mt_rand(1000000, 9999999);
            } while (Cart::where('cart_id', $cartId)->exists());
        }
    
        // Store or update cart item
        Cart::updateOrCreate(
            $match,
            [
                'quantity' => $request->quantity,
                'cart_id' => $cartId
            ]
        );
    
        return back()->with('success', 'Product added to cart!');
    }
    

    public function cart(Request $request)
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
    
        return view('frontend.cart', ['cartItems' => $cartItems]);
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
    
        return view('frontend.checkout', compact('addresses', 'cartItems'));
    }
    public function placeOrder(Request $request)
    {
        $request->validate([
            'billing_address' => 'required|exists:addresses,id',
        ]);
    
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
    
        // Create Order
        $order = new Order();
        $order->user_id = $userId;
        $order->address_id = $request->billing_address;
        $order->total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $order->status = 'pending';
        $order->save();
    
        // Create Order Items
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item->product_id,
                'quantity'   => $item->quantity,
                'price'      => $item->product->price,
            ]);
        }

        if ($request->payment_mode === 'online') {
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
    
        return redirect()->route('order.success')->with('success', 'Order placed successfully!');
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
    public function applyCoupon(Request $request)
    {
        $code = $request->input('coupon_code');
        $coupon = Coupon::where('code', $code)
            ->where('is_active', 1)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->first();
    
        if (!$coupon) {
            return back()->with('error', 'Invalid or expired coupon code.');
        }
    
        // Optional: Check usage limits
        if ($coupon->used >= $coupon->max_usage) {
            return back()->with('error', 'This coupon has reached its usage limit.');
        }
    
        // Save coupon in session
        Session::put('coupon', [
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
            'min_cart_value' => $coupon->min_cart_value,
        ]);
    
        return back()->with('success', 'Coupon applied successfully!');
    }public function removeCoupon()
    {
        session()->forget('coupon');
        return back()->with('success', 'Coupon removed.');
    }
}
