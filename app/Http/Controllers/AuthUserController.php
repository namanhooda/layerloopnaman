<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Order;
use App\Models\Address;
use App\Models\ProductReview;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use App\Mail\TestMail;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Mail;

class AuthUserController extends Controller
{
    public function account()
    {
        return view('frontend.account');
    }

    public function orders()
    {
        $orders = Order::where('user_id', Auth::user()->id)->get();
        return view('frontend.user.orders', compact('orders'));
    }
    public function accountSettings()
    {
        return view('frontend.user.accountSettings');
    }
    public function addresses()
    {
        $userId = auth()->id();
        $addresses = Address::where('user_id', $userId)->get();
        return view('frontend.user.addresses', compact('addresses'));
    }
    public function wallet()
{
    $userId = auth()->id();

    // Get wallet balance (first wallet record for the user)
    $wallet = Wallet::where('user_id', $userId)->first();

    // Get wallet transactions for the user
    $transactions = WalletTransaction::where('user_id', $userId)
        ->orderBy('created_at', 'desc')
        ->get();

    return view('frontend.user.wallet', compact('wallet', 'transactions'));
}

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'current_password' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update basic info
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;

        // Handle password update if provided
        if ($request->filled('current_password') && $request->filled('password')) {
            if (Hash::check($request->current_password, $user->password)) {
                $user->password = Hash::make($request->password);
            } else {
                return back()->withErrors(['current_password' => 'Current password does not match.']);
            }
        }

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->profile = $path;
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }

    public function orderDetail($order_code)
    {
        $order = Order::with(['itemsData.product', 'user', 'address'])
            ->where('order_code', $order_code)
            ->first();

        if (!$order) {
            return redirect()->route('home')->with('error', 'Order not found.');
        }

        return view('frontend.user.order-detail', compact('order'));
    }
   public function cancelOrder($id, Request $request)
    {
        $request->validate([
            'cancel_reason' => 'required|string|max:255',
            'cancel_note'   => 'nullable|string|max:500',
        ]);

        $order = Order::where('id', $id)
                    ->where('user_id', auth()->id())
                    ->firstOrFail();

        if ($order->status === 'cancelled') {
            return back()->with('error', 'Order already cancelled.');
        }

        if ($order->status === 'completed' || $order->status === 'Delivered') {
            return back()->with('error', 'This order cannot be cancelled.');
        }

        $order->status = 'cancelled';
        $order->cancel_reason = $request->cancel_reason;
        $order->cancel_note   = $request->cancel_note;
        $order->save();

        return back()->with('success', 'Order has been cancelled successfully.');
    }

}
