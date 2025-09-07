<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    //

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
            'billing_address' => 'required|exists:addresses,id',
        ], [
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
    
        // Create Order
        $order = new Order();
        $order->user_id = $userId;
        $order->address_id = $request->billing_address;
        $order->shipping_type = $request->shipping_type;

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
}
