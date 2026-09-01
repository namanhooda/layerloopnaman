<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\Product;
use Illuminate\Support\Facades\Http;

class ShiprocketProductController extends Controller
{
    //


public function products(Request $request)
{
    set_time_limit(0);
    $page = max((int) $request->get('page', 1), 1);
    $limit = max((int) $request->get('limit', 100), 1);
    $collectionId = $request->get('collection_id');

    $query = Product::where('status', 'Published');

    // Filter by collection/category
    if (!empty($collectionId)) {
        $query->whereRaw("FIND_IN_SET(?, category)", [$collectionId]);
    }

    $total = $query->count();

    $products = $query
    ->latest('created_at')
    ->take(50)
    ->get();

    $response = [];

    $apiKey = env('SHIPROCKET_CHECKOUT_KEY');
    $apiSecret = env('SHIPROCKET_CHECKOUT_SECRET');

    $shiprocketUrl = 'https://checkout-api.shiprocket.com/wh/v1/custom/product';

    foreach ($products as $product) {

        $image = $product->featured_image
            ? asset('storage/' . $product->featured_image)
            : '';

        /*
        |--------------------------------------------------------------------------
        | Prepare Shiprocket Product
        |--------------------------------------------------------------------------
        */

        $payload = [

            "id" => (int) $product->id,

            "title" => $product->name,

            "body_html" => "Layerloop3d customized " . $product->name,

            "vendor" => "LayerLoop",

            "product_type" => $product->product_type ?? "3D Printed",

            "created_at" => optional($product->created_at)->toIso8601String(),

            "handle" => $product->slug,

            "updated_at" => optional($product->updated_at)->toIso8601String(),

            "tags" => $product->tags ?? "",

            "status" => "active",

            "variants" => [

                [
                    "id" => (int) ("808185" . $product->id),

                    "title" => $product->name,

                    "price" => number_format(
                        $product->price ?? 0,
                        2,
                        '.',
                        ''
                    ),

                    "compare_at_price" => number_format(
                        $product->price ?? 0,
                        2,
                        '.',
                        ''
                    ),

                    "sku" => $product->code,

                    "created_at" => optional(
                        $product->created_at
                    )->toIso8601String(),

                    "updated_at" => optional(
                        $product->updated_at
                    )->toIso8601String(),

                    "quantity" => (int) ($product->quantity ?? 20),

                    "taxable" => false,

                    "grams" => (int) ($product->weight ?? 100),

                    "image" => [
                        "src" => $image
                    ],

                    "weight" => (float) ($product->weight ?? 0.100),

                    "weight_unit" => "kg",

                    "option_values" => new \stdClass(),
                ]

            ],

            "image" => [
                "src" => $image
            ],

            "options" => []
        ];

        /*
        |--------------------------------------------------------------------------
        | Convert EXACT payload to JSON
        |--------------------------------------------------------------------------
        */

        $jsonPayload = json_encode(
            $payload,
            JSON_UNESCAPED_SLASHES
        );

        /*
        |--------------------------------------------------------------------------
        | Generate Shiprocket HMAC SHA256
        |--------------------------------------------------------------------------
        */

        $hmac = base64_encode(
            hash_hmac(
                'sha256',
                $jsonPayload,
                $apiSecret,
                true
            )
        );

        /*
        |--------------------------------------------------------------------------
        | Send Product to Shiprocket
        |--------------------------------------------------------------------------
        */

        $shiprocketResponse = Http::withHeaders([
            'X-Api-Key' => $apiKey,
            'X-Api-HMAC-SHA256' => $hmac,
            'Content-Type' => 'application/json',
        ])
        ->withBody($jsonPayload, 'application/json')
        ->post($shiprocketUrl);

        /*
        |--------------------------------------------------------------------------
        | Store Shiprocket response in our API response
        |--------------------------------------------------------------------------
        */

        $response[] = [
            ...$payload,

            "shiprocket" => [
                "status" => $shiprocketResponse->status(),
                "success" => $shiprocketResponse->successful(),
                "response" => $shiprocketResponse->json(),
            ]
        ];
    }

    return response()->json([
        "data" => [
            "total" => $total,
            "products" => $response
        ]
    ]);
}
}
