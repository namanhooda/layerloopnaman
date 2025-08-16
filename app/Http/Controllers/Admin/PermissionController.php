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
            ->addColumn('actions', function ($permission) {
                return '<div class="d-flex align-items-center">
                <span class="text-nowrap">
                 <button 
                    class="btn btn-icon me-1 edit-permission" 
                    data-id="'.$permission->id.'" 
                    data-name="'.$permission->name.'" 
                    data-bs-target="#editPermissionModal" 
                    data-bs-toggle="modal">
                    <i class="icon-base ti tabler-edit icon-22px"></i>
                </button>
                  <a href="javascript:;" class="btn btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="icon-base ti tabler-dots-vertical icon-22px"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-end m-0">
                    <a href="javascript:;" class="dropdown-item">Edit</a>
                    <a href="javascript:;" class="dropdown-item">Suspend</a>
                  </div>
                </span>
              </div>'; // JS handles this now
            })
            ->rawColumns(['assigned_to', 'actions'])
            ->make(true);
    }

    return view('admin.permissions.index');
}public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|unique:permissions,name',
    ]);

    Permission::create([
        'name' => $request->name,
        'guard_name' => 'web', // 👈 Set it here, not in validate()
    ]);

    return redirect()->back()->with('success', 'Permission created successfully!');
}
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $id,
        ]);
    
        $permission = Permission::findOrFail($id);
        $permission->update(['name' => $request->name]);
    
        return response()->json(['success' => true]);
    }
    
}
