<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $permissions = Permission::with('roles')->select('permissions.*');

            return DataTables::of($permissions)
                ->addIndexColumn()
                ->addColumn('assigned_to', function ($permission) {
                    return $permission->roles->pluck('name')->implode(', ');
                })
                ->addColumn('created_at', function ($permission) {
                    return $permission->created_at->format('d M, Y h:i A');
                })
                ->rawColumns(['assigned_to', 'actions'])
                ->make(true);
        }

        return view('admin.permissions.index');
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:permissions,name',
            ]);

            Permission::create([
                'name' => $request->name,
                'guard_name' => 'web', // default guard
            ]);

            return redirect()->back()->with('success', 'Permission created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create permission. Please try again. Error: ' . $e->getMessage());
        }
    }

    
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:permissions,name,' . $id,
            ]);

            $permission = Permission::findOrFail($id);
            $permission->update(['name' => $request->name]);

            return redirect()->back()->with('success', 'Permission updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update permission. Please try again. Error: ' . $e->getMessage());
        }
    }

    
}
