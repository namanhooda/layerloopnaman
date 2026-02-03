<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShiprocketWebhookController extends Controller
{
    //

    public function handle(Request $request)
{
    $data = $request->all();

    $order = Order::create([
        'shiprocket_order_id' => $data['order_id'],
        'phone' => $data['phone'],
        'email' => $data['email'],
        'amount' => $data['total_amount_payable'],
        'payment_type' => $data['payment_type'],
        'status' => $data['status']
    ]);

    // clear guest cart
    Cart::where('cart_id', session('cart_id'))->delete();

    session()->forget('cart_id');

    return response()->json(['success' => true]);
}

}
