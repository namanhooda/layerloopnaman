<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    //

public function ajax(Request $request)
{
    $q = trim($request->q);

    if (!$q) {
        return response()->json([
            'suggestions' => [],
            'products' => [],
        ]);
    }

    $products = Product::where('name', 'LIKE', "%{$q}%")
        ->limit(8)
        ->get();

    return response()->json([
        // Suggestions (names only)
        'suggestions' => $products->pluck('name'),

        // Products (for search cards)
        'products' => $products->map(function ($p) {
            return [
                'id'    => $p->id,
                'name'  => $p->name,
                'slug'  => $p->slug,
                'price' => $p->discounted_price ?? $p->price,
                'image' => $p->featured_image
                    ? asset('storage/' . $p->featured_image)
                    : asset('frontend/assets/images/no-image.png'),
            ];
        }),
    ]);
}


}
