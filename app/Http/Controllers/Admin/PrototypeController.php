<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prototype;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PrototypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Prototype::latest()->get();

        if ($request->ajax()) {
            $users = $categories; // eager load roles

            return DataTables::of($users)
                ->addIndexColumn()
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
                    $editUrl = route('admin.product-prototypes.edit', $user->id);
                    $deleteUrl = route('admin.product-prototypes.destroy', $user->id);
                
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
                
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('admin.product_prototypes.index', compact('categories'));
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
            'name' => 'required|string|max:255',
        ]);

        Prototype::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => 'active',
        ]);

        return redirect()->route('admin.product-prototypes.index')->with('success', 'Prototype created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Prototype $prototype)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prototype $prototype)
    {
        return view('admin.product_prototypes.edit', compact('prototype'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prototype $prototype)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $prototype->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->status,
        ]);

        return redirect()->route('admin.product-prototypes.index')->with('success', 'Prototype updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prototype $prototype)
    {
        $prototype->delete();
        return redirect()->route('admin.product-prototypes.index')->with('success', 'Category deleted successfully.');
    }
}
