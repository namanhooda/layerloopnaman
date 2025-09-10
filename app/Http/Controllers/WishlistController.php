<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = auth()->id();

        // Use the same system_id logic for guest tracking
        $systemId = null;
        $rawIdentifier = $request->userAgent() . '|' . $request->ip();
        $systemId = hash('sha256', $rawIdentifier);

        if ($userId && $systemId) {
            // Migrate guest wishlist items to the logged-in user
            Wishlist::where('system_id', $systemId)
                ->whereNull('user_id') // only migrate unassigned
                ->update([
                    'user_id' => $userId,
                    'system_id' => null
                ]);
        }

        $wishlist = Wishlist::with('product')
            ->where(function ($query) use ($userId, $systemId) {
                $query->when($userId, fn($q) => $q->where('user_id', $userId))
                    ->when(!$userId && $systemId, fn($q) => $q->where('system_id', $systemId));
            })
            ->get();

        if ($wishlist->isEmpty()) {
            return redirect('/')
                ->with('error', 'Your wishlist is empty.');
        }

        return view('frontend.wishlist', compact('wishlist'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
    ]);
    $userId = auth()->id();
    $systemId = $userId ? null : hash('sha256', $request->userAgent() . '|' . $request->ip());

    $exists = Wishlist::where(function ($query) use ($userId, $systemId) {
        if ($userId) $query->where('user_id', $userId);
        else $query->where('system_id', $systemId);
    })->where('product_id', $request->product_id)->exists();

    if ($exists) {
        return response()->json([
            'success' => true,
            'message' => 'Already in wishlist',
            'count'   => \App\Helpers\CartHelper::getWishlistCount()
        ]);
    }

    Wishlist::create([
        'user_id'    => $userId,
        'system_id'  => $systemId,
        'product_id' => $request->product_id
    ]);

    return response()->json([
            'success' => true,
            'message' => 'Product added to Wishlist!',
        'count'   => \App\Helpers\CartHelper::getWishlistCount()
    ]);
}



    /**
     * Display the specified resource.
     */
    public function show(Wishlist $wishlist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wishlist $wishlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wishlist $wishlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wishlist $wishlist)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())->findOrFail($wishlist->id);
        $wishlist->delete();

        return redirect()->back()->with('success', 'Removed from wishlist');
    }
}
