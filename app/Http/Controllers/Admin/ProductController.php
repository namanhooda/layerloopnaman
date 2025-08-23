<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $product = Product::latest()->get(); // eager load roles

            return DataTables::of($product)
                ->addIndexColumn()
                ->addColumn('code', function ($product) {
                    return $product->code ?? 'N/A';
                })
                ->addColumn('image', function ($product) {
                    $imageUrl = asset('storage/' . $product->featured_image);
                    return '<img src="' . $imageUrl . '" alt="Product image" class="product-image product-image-manual" style="width: 100%;!important">';
                })
                ->addColumn('name', function ($product) {
                    return $product->name ?? 'N/A';
                })
                ->editColumn('category', function ($product) {
                    return $product->category ?? 'N/A';
                })
                ->addColumn('stock', function ($product) {
                    return $product->stock_quantity;
                })
                ->addColumn('price', function ($product) {
                    return $product->price;
                })
                ->addColumn('status', function ($product) {
                    return $product->status;
                })
                ->addColumn('actions', function ($product) {
                    $editUrl = route('admin.products.edit', $product->id);
                    $deleteUrl = route('admin.products.destroy', $product->id);
                
                    $actions = '<div class="d-flex align-items-center">';
                
                    // Edit button (optional permission check)
                    if (auth()->user()->can('users edit')) {
                        $actions .= '<a class="btn btn-icon me-1" href="' . $editUrl . '" title="Edit">
                                        <i class="icon-base ti tabler-edit icon-22px"></i>
                                    </a>';
                    }
                
                    // Delete form/button (optional permission check)
                    if (auth()->user()->can('users delete')) {
                        $actions .= '<form action="' . $deleteUrl . '" method="POST" onsubmit="return confirm(\'Are you sure?\')" style="display:inline;">
                                        ' . csrf_field() . method_field('DELETE') . '
                                        <button class="btn btn-icon btn-sm btn-danger" type="submit" title="Delete">
                                            <i class="icon-base ti tabler-trash icon-22px"></i>
                                        </button>
                                    </form>';
                    }
                
                    $actions .= '</div>';
                
                    return $actions;
                })
                ->rawColumns(['image','roles', 'actions'])
                ->make(true);
        }

        return view('admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $categories = NewsCategory::latest()->get();
        return view('admin.product.create');
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
                'price' => 'required|numeric',
                'discount_price' => 'nullable|numeric',
                'stock' => 'required|integer|min:0',
                'featuredimage' => 'nullable|image|mimes:jpeg,png,webp,jpg|max:5000',
                'images.*' => 'nullable|image|mimes:jpeg,webp,png,jpg|max:5000',
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

            $code = 'LL' . str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT);

            Product::create([
                'name' => $request->productTitle,
                'sku' => $request->productSku,
                'code' => $code,
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
