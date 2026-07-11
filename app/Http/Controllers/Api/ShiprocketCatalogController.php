<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\Product;

class ShiprocketCatalogController extends Controller
{
    public function products(Request $request)
    {
        $page = max((int)$request->get('page', 1), 1);
        $limit = max((int)$request->get('limit', 100), 1);

        $query = Product::where('status', 'Published');

        $total = $query->count();

        $products = $query
            ->skip(($page - 1) * $limit)
            ->take($limit)
            ->get();

        $response = [];

        foreach ($products as $product) {

            $image = $product->featured_image
                ? asset('storage/' . $product->featured_image)
                : '';

            $response[] = [

                "id" => (int)$product->id,

                "title" => $product->name,

                "body_html" => 'Layerloop3d customized'.$product->name ,

                "vendor" => "LayerLoop",

                "product_type" => $product->product_type ?? "3D Printed",

                "created_at" => optional($product->created_at)->toIso8601String(),

                "handle" => $product->slug,

                "updated_at" => optional($product->updated_at)->toIso8601String(),

                "tags" => $product->tags ?? "",

                "status" => "active",

                "variants" => [

                    [
                        "id" => (int)(808185 .$product->id),

                        "title" => $product->name,

                        "price" => number_format($product->price ?? 0, 2, '.', ''),

                        "compare_at_price" => number_format($product->price ?? 0, 2, '.', ''),

                        "sku" => $product->code,

                        "quantity" => (int)($product->quantity ?? 20),

                        "created_at" => optional($product->created_at)->toIso8601String(),

                        "updated_at" => optional($product->updated_at)->toIso8601String(),

                        "taxable" => false,

                        "option_values" => new \stdClass(),

                        "grams" => (int)(($product->weight ?? 100)),

                        "image" => [
                            "src" => $image
                        ],

                        "weight" => (float)($product->weight ?? 0.100),

                        "weight_unit" => "kg"
                    ]

                ],

                "image" => [
                    "src" => $image
                ],

                "options" => []
            ];
        }

        return response()->json([
            "data" => [
                "total" => $total,
                "products" => $response
            ]
        ]);
    }
    public function collections(Request $request)
{
    $page = max((int)$request->page, 1);
    $limit = max((int)$request->limit, 100);

    $query = ProductCategory::where('status', 'active');

    $total = $query->count();

    $collections = $query
        ->skip(($page - 1) * $limit)
        ->take($limit)
        ->get();

    $data = [];

    foreach ($collections as $category) {

        $image = '';

        if (!empty($category->featured_image)) {
            $image = asset('storage/' . $category->featured_image);
        }

        $data[] = [

            "id" => (int)$category->id,

            "updated_at" => optional($category->updated_at)->toIso8601String(),

            "body_html" => 'Layerloop 3d printed ' .$category->name ?? "",

            "handle" => $category->slug,

            "image" => [
                "src" => $image
            ],

            "title" => $category->name,

            "created_at" => optional($category->created_at)->toIso8601String(),
        ];
    }

    return response()->json([
        "data" => [
            "total" => $total,
            "collections" => $data
        ]
    ]);
}
}