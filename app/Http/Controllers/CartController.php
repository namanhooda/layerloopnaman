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
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1'
        ]);

        $userId = auth()->id();

        if (!$userId) {
            $rawIdentifier = $request->userAgent() . '|' . $request->ip();
            $systemId = hash('sha256', $rawIdentifier);
        } else {
            $systemId = null;
        }

        $match = ['product_id' => $request->product_id];
        if ($userId) $match['user_id'] = $userId;
        else $match['system_id'] = $systemId;

        $existingCartItem = Cart::where(function ($query) use ($userId, $systemId) {
            if ($userId) $query->where('user_id', $userId);
            else $query->where('system_id', $systemId);
        })->first();

        if ($existingCartItem) {
            $cartId = $existingCartItem->cart_id;
        } else {
            do {
                $cartId = 'CRT' . mt_rand(1000000, 9999999);
            } while (Cart::where('cart_id', $cartId)->exists());
        }

        Cart::updateOrCreate(
            $match,
            [
                'quantity' => $request->quantity,
                'cart_id' => $cartId
            ]
        );

        // Return JSON instead of redirect
        return response()->json([
            'success' => true,
            'message' => 'Product added to cart!'
        ]);
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
            
        if ($cartItems->isEmpty()) {
            return redirect('/')
                ->with('error', 'Your cart is empty.');
        }

        return view('frontend.cart', ['cartItems' => $cartItems]);
    }

    public function removeItem(Request $request)
    {
        $cartItemId = $request->input('cart_item_id');

        $cartItem = Cart::find($cartItemId);

        if (!$cartItem) {
            return redirect()->back()->with('error', 'Cart item not found.');
        }

        $cartItem->delete();

        return redirect()->back()->with('success', 'Item removed from cart.');
    }

    public function setShipping(Request $request)
    {
        $shipping = [
            'type'  => $request->type,
            'label' => $request->label,
            'price' => $request->price,
        ];

        session(['shipping' => $shipping]);

        return response()->json([
            'status' => 'success',
            'shipping' => $shipping
        ]);
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
    }
    
    public function removeCoupon()
    {
        session()->forget('coupon');
        return back()->with('success', 'Coupon removed.');
    }
}
