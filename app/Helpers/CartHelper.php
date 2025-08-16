<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CartHelper
{
    public static function getCartCount()
    {
        $request = request(); 
        if (Auth::check()) {
            // Logged in user - use user_id
            return Cart::where('user_id', Auth::id())->sum('quantity');
        } else {
            // Guest - use session_id
            
            $systemId = null;
                $rawIdentifier = $request->userAgent() . '|' . $request->ip();
                $systemId = hash('sha256', $rawIdentifier);
            return Cart::where('system_id', $systemId)->count();
        }
    }
    public static function getCart()
    {
        $request = request(); 
        if (Auth::check()) {
            // Logged in user - use user_id
            return Cart::where('user_id', Auth::id())->get();
        } else {
            // Guest - use session_id
            
            $systemId = null;
                $rawIdentifier = $request->userAgent() . '|' . $request->ip();
                $systemId = hash('sha256', $rawIdentifier);
            return Cart::where('system_id', $systemId)->get();
        }
    }
    public static function getCaregories()
    {
            return ProductCategory::get();
    }
}
