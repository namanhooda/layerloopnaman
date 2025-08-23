<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::all();
        if ($request->ajax()) {
            $users = User::with('roles')->get(); // eager load roles

            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('roles', function ($user) {
                    return $user->roles->pluck('name')->implode(', ');
                })->addColumn('roles', function ($user) {
                    return $user->roles->pluck('name')->implode(', ') ?? 'N/A';
                })
                ->addColumn('email', function ($user) {
                    return $user->email;
                })
                ->addColumn('mobile', function ($user) {
                    return $user->phone ?? 'N/A';
                })
                ->editColumn('status', function ($user) {
                    if($user->status == 0){
                        $status = "Inactive";
                    }else{

                        $status = "Active";
                    }
                    return $status;
                })
                ->addColumn('created_at', function ($user) {
                    return $user->created_at;
                })
                ->addColumn('actions', function ($user) {
                    $editUrl = route('admin.users.edit', $user->id);
                    $deleteUrl = route('admin.users.destroy', $user->id);
                
                    $actions = '<div class="d-flex align-items-center">';
                
                    if (auth()->user()->can('users edit')) {
                        $actions .= '<a class="btn btn-icon me-1 edit-user" href="' . $editUrl . '">
                                        <i class="icon-base ti tabler-edit icon-22px"></i>
                                    </a>';
                    }
                
                    if (auth()->user()->can('users delete')) {
                        $actions .= '<form action="' . $deleteUrl . '" method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure you want to delete this user?\');">
                                        ' . csrf_field() . method_field('DELETE') . '
                                        <button type="submit" class="btn btn-icon btn-danger">
                                            <i class="icon-base ti tabler-trash icon-22px"></i>
                                        </button>
                                    </form>';
                    }
                
                    $actions .= '</div>';
                
                    return $actions;
                })
                ->rawColumns(['roles', 'actions'])
                ->make(true);
        }

        return view('admin.users.index', compact('roles'));
    }
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'mobile' => 'nullable|string|max:15',
                'role_id' => 'required|exists:roles,id',
            ]);

            // Create the user
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['mobile'],
                'password' => Hash::make('password123'), // default password
                'status' => 1,
            ]);

            // Assign role
            $role = Role::find($validated['role_id']);
            $user->assignRole($role);

            return redirect()->route('admin.users.index')->with('success', 'User created and role assigned successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create user. Please try again.');
        }
    }

    public function edit(User $User)
    {
        $user = $User;
        return view('admin.users.edit', compact('user'));
    }
    public function update(Request $request, User $user)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
                'mobile' => ['nullable', 'string', 'max:15'],
                'password' => ['nullable', 'confirmed', 'min:6'],
                'image' => ['nullable', 'image', 'max:2048'],
                'status' => ['required', 'boolean'],
            ]);

            $user->name   = $request->name;
            $user->email  = $request->email;
            $user->phone  = $request->mobile;
            $user->status = $request->status;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($user->profile && Storage::disk('public')->exists($user->profile)) {
                    Storage::disk('public')->delete($user->profile);
                }

                // Upload new image to profile-photos (public disk)
                $user->profile = $request->file('image')->store('profile-photos', 'public');
            }

            $user->save();

            return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Failed to update user. Please try again.' .$e->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            // Delete profile image if exists
            if ($user->profile && Storage::disk('public')->exists($user->profile)) {
                Storage::disk('public')->delete($user->profile);
            }

            $user->delete();

            return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('User delete failed: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Failed to delete user. Please try again.');
        }
    }


}
