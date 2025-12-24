<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Prototype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $product = Product::query()->orderByDesc('id'); // or created_at

            return DataTables::of($product)
                ->addIndexColumn()
                ->addColumn('code', fn ($product) => $product->code ?? 'N/A')
                ->addColumn('image', function ($product) {
                    $imageUrl = asset('storage/' . $product->featured_image);
                    return '<img src="'.$imageUrl.'" class="product-image product-image-manual" style="width:100%">';
                })
                ->addColumn('name', fn ($product) => $product->name ?? 'N/A')
                ->editColumn('category', fn ($product) => $product->category ?? 'N/A')
                ->addColumn('stock', fn ($product) => $product->stock_quantity)
                ->addColumn('price', fn ($product) => $product->price)
                ->addColumn('status', fn ($product) => $product->status)
                ->addColumn('actions', function ($product) {
                    $editUrl = route('admin.products.edit', $product->id);
                    $deleteUrl = route('admin.products.destroy', $product->id);
                    $variantUrl = route('admin.products.variant', $product->id);

                    $actions = '<div class="d-flex align-items-center">';

                    if (auth()->user()->can('users edit')) {
                        $actions .= '<a class="btn btn-primary btn-sm" href="'.$variantUrl.'">
                                        Add Variant
                                    </a>';
                    }
                    if (auth()->user()->can('users edit')) {
                        $actions .= '<a class="btn btn-icon me-1" href="'.$editUrl.'">
                                        <i class="icon-base ti tabler-edit"></i>
                                    </a>';
                    }

                    if (auth()->user()->can('users delete')) {
                        $actions .= '<form action="'.$deleteUrl.'" method="POST" style="display:inline;">
                                        '.csrf_field().method_field('DELETE').'
                                        <button class="btn btn-danger btn-icon btn-sm">
                                            <i class="icon-base ti tabler-trash"></i>
                                        </button>
                                    </form>';
                    }

                    return $actions.'</div>';
                })
                ->rawColumns(['image', 'actions'])
                ->make(true);
        }
        return view('admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $prototypes = Prototype::get();
        return view('admin.product.create',compact('prototypes'));
    }
    public function variantCreate($id)
    {
        $product = Product::find($id);
        $prototypes = Prototype::get();
        return view('admin.product.create',compact('prototypes', 'product'));
    }
    public function getCategories($prototypeId)
    {
        $categories = ProductCategory::where('prototype_id', $prototypeId)
            ->select('id', 'name')
            ->get();

        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'productTitle' => 'required|string|max:255',
                'productSku' => 'nullable|string|max:255',
                'productBarcode' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'price' => 'nullable|numeric',
                'discount_price' => 'required|numeric',
                'stock' => 'required|integer|min:0',
                'featuredimage' => 'nullable|image|mimes:jpeg,png,webp,jpg|max:5000',
                'images.*' => 'nullable|image|mimes:jpeg,webp,png,jpg|max:5000',
                'prototype' => 'required|string',
                'category' => 'required|string',
                'status' => 'nullable|string',
                'tags' => 'nullable|string',
            ]);

            // Handle single featured image
            $featuredImagePath = null;
            if ($request->hasFile('featuredimage')) {
                $featuredImagePath = $request->file('featuredimage')->store('product_featured', 'public');
            }

            // Handle multiple product images
            $imagePaths = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePaths[] = $image->store('product_images', 'public');
                }
            }
            $size = null;
            if($request->prototype == 'clothing' && $request->has('sizes')){
                $size = json_encode($request->sizes); // convert array to JSON string
            }
            $code = 'LL' . str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT);
            $discountedPrice = $request->discount_price;

            Product::create([
                'slug' => Str::slug($request->productTitle),
                'name' => $request->productTitle,
                'sku' => $request->productSku,
                'code' => $code,
                'barcode' => $request->productBarcode,
                'description' => $request->description,
                'price' => $request->discount_price,
                'discounted_price' => $request->discount_price,
                'size' => $size,
                'stock_quantity' => $request->stock,
                'charge_tax' => $request->has('charge_tax'),
                'in_stock' => $request->has('in_stock'),
                'image_path' => !empty($imagePaths) ? json_encode($imagePaths) : null,
                'featured_image' => $featuredImagePath,
                'prototype' => $request->prototype,
                'category' => $request->category,
                'status' => $request->status ?? 'Draft',
                'tags' => $request->tags,
                'is_draft' => $request->has('draft'),
            ]);

            return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to create product. Please try again. Error: ' . $e->getMessage());
        }
    }

    
    

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('admin.product.edit',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
{
    $request->validate([
        'productTitle' => 'required|string|max:255',
        'productSku' => 'nullable|string|max:255',
        'productBarcode' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'discount_price' => 'nullable|numeric',
        'stock' => 'required|integer|min:0',
        'featuredimage' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'category' => 'required|string',
        'status' => 'nullable|string',
        'tags' => 'nullable|string',
    ]);

    $product = Product::findOrFail($id);

    // Handle featured image update
    $featuredImagePath = $product->featured_image;
    if ($request->hasFile('featuredimage')) {
        $featuredImagePath = $request->file('featuredimage')->store('product_featured', 'public');
    }

    // Handle new image uploads (optional append or replace logic)
    $imagePaths = $product->image_path ? json_decode($product->image_path, true) : [];
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $imagePaths[] = $image->store('product_images', 'public');
        }
    }

    $product->update([
        'name' => $request->productTitle,
        'sku' => $request->productSku,
        'barcode' => $request->productBarcode,
        'description' => $request->description,
        'price' => $request->price,
        'discounted_price' => $request->discount_price,
        'stock_quantity' => $request->stock,
        'charge_tax' => $request->has('charge_tax'),
        'in_stock' => $request->has('in_stock'),
        'image_path' => !empty($imagePaths) ? json_encode($imagePaths) : null,
        'featured_image' => $featuredImagePath,
        'category' => $request->category,
        'status' => $request->status ?? 'Draft',
        'tags' => $request->tags,
        'is_draft' => $request->has('draft'),
    ]);

    return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
