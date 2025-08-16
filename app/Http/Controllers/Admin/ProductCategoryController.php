<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Models\ProductCategory;
use Illuminate\Support\Str;
use App\Models\Prototype;

use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = ProductCategory::latest()->get();
        $prototype = Prototype::get();

        if ($request->ajax()) {
            $users = $categories; // eager load roles

            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('prototype', function ($user) {

                    $prototype = Prototype::find($user->prototype_id);
                    return $prototype->name;
                })
                ->addColumn('name', function ($user) {
                    return $user->name;
                })
                ->addColumn('slug', function ($user) {
                    return $user->slug;
                })
                ->addColumn('status', function ($user) {
                    return $user->status;
                })
                ->addColumn('actions', function ($user) {
                    $editUrl = route('admin.product-categories.edit', $user->id);
                    $deleteUrl = route('admin.product-categories.destroy', $user->id);
                
                    return '
                    <div class="d-flex align-items-center">
                        <span class="text-nowrap">
                            <a class="btn btn-icon me-1 edit-user" href="' . $editUrl . '">
                                <i class="icon-base ti tabler-edit icon-22px"></i>
                            </a>
                
                            <form action="' . $deleteUrl . '" method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure you want to delete this category?\')">
                                ' . csrf_field() . method_field('DELETE') . '
                                <button type="submit" class="btn btn-icon btn-sm btn-danger">
                                    <i class="icon-base ti ti-trash icon-22px"></i>
                                </button>
                            </form>
                        </span>
                    </div>';
                })
                
                ->rawColumns(['prototype','roles', 'actions'])
                ->make(true);
        }
        return view('admin.product_categories.index', compact('categories','prototype'));
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
            'prototype_id' => 'required|string|max:255',
            'name' => 'required|string|max:255',
        ]);

        ProductCategory::create([
            'prototype_id' => $request->prototype_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => 'active',
        ]);

        return redirect()->route('admin.product-categories.index')->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $productCategory)
    {
        $prototypes = Prototype::get();
        return view('admin.product_categories.edit', compact('productCategory','prototypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $productCategory->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.product-categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $ProductCategory)
    {
        $ProductCategory->delete();
        return redirect()->route('admin.product-categories.index')->with('success', 'Category deleted successfully.');
    }
}
