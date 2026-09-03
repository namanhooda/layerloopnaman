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
use Illuminate\Support\Facades\Log;
use App\Jobs\ProcessFastrrOrder;


class ShiprocketCheckoutWebhookController extends Controller
{
    public function orderForm(Request $request)
    {
        return view('admin.orders.checkoutform');
    }
   public function handle(Request $request)
{
    $cartId = $request->input('cart_id');

    Log::info('Fastrr webhook received', [
        'cart_id' => $cartId,
        'payload' => $request->all(),
    ]);

    if (!$cartId) {
        return response()->json([
            'status' => false,
            'message' => 'cart_id missing'
        ], 400);
    }

    ProcessFastrrOrder::dispatch($cartId)
        ->delay(now()->addSeconds(10));

    return response()->json([
        'status' => true
    ], 200);
}
}
