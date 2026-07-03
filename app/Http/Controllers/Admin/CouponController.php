<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $order = Coupon::get(); // eager load roles

            return DataTables::of($order)
                ->addIndexColumn()
                ->addColumn('coupon_code', function ($order) {
                    return $order->code ?? 'N/A';
                })
                ->addColumn('type', function ($order) {
                    return $order->type ?? 'N/A';
                })
                ->addColumn('value', function ($order) {
                    return $order->value ?? 'N/A';
                })
                ->addColumn('actions', function ($user) {
                    $editUrl = route('admin.coupons.edit', $user->id);
                    $deleteUrl = route('admin.coupons.destroy', $user->id);
                
                    $actions = '<div class="d-flex align-items-center">';
                
                    
                        $actions .= '<a class="btn btn-icon me-1 edit-user" href="' . $editUrl . '">
                                        <i class="icon-base ti tabler-eye icon-22px"></i>
                                    </a>';
                        $actions .= '<form action="' . $deleteUrl . '" method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure you want to delete this Coupon?\');">
                                        ' . csrf_field() . method_field('DELETE') . '
                                        <button type="submit" class="btn btn-icon btn-danger">
                                            <i class="icon-base ti tabler-trash icon-22px"></i>
                                        </button>
                                    </form>';
                    
                
                    $actions .= '</div>';
                
                    return $actions;
                })
                ->rawColumns(['roles', 'actions','type','value'])
                ->make(true);
        }

        return view('admin.coupons.index');
    }
    public function create()
    {
        return view('admin.coupons.create');
    }
public function store(Request $request)
{
    try {

        $validated = $request->validate([
            'code' => 'required|unique:coupons,code|max:255',
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric|min:0',
            'min_cart_value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'max_usage' => 'required|integer|min:1',
            'is_active' => 'required|boolean',
        ]);

        $validated['used'] = 0;

        Coupon::create($validated);

        return redirect()
            ->route('admin.coupons.index')
            ->with('success', 'Coupon created successfully.');

    } catch (\Illuminate\Validation\ValidationException $e) {

        dd($e);
        // Validation errors
        return redirect()
            ->back()
            ->withErrors($e->validator)
            ->withInput();

    } catch (\Illuminate\Database\QueryException $e) {

        dd($e);
        // Database errors
        return redirect()
            ->back()
            ->with('error', 'Database Error: ' . $e->getMessage())
            ->withInput();

    } catch (\Exception $e) {
        dd($e);

        // Other errors
        return redirect()
            ->back()
            ->with('error', 'Something went wrong: ' . $e->getMessage())
            ->withInput();
    }
}

public function edit($id)
{
    try {

        $coupon = Coupon::findOrFail($id);

        return view('admin.coupons.edit', compact('coupon'));

    } catch (\Exception $e) {

        return redirect()
            ->route('admin.coupons.index')
            ->with('error', 'Coupon not found.');
    }
}


public function update(Request $request, $id)
{
    try {

        $coupon = Coupon::findOrFail($id);

        $validated = $request->validate([
            'code' => 'required|max:255|unique:coupons,code,' . $coupon->id,
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric|min:0',
            'min_cart_value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'max_usage' => 'required|integer|min:1',
            'is_active' => 'required|boolean',
        ]);

        $coupon->update($validated);

        return redirect()
            ->route('admin.coupons.index')
            ->with('success', 'Coupon updated successfully.');

    } catch (\Illuminate\Validation\ValidationException $e) {

        return redirect()
            ->back()
            ->withErrors($e->validator)
            ->withInput();

    } catch (\Illuminate\Database\QueryException $e) {

        return redirect()
            ->back()
            ->with('error', 'Database Error: ' . $e->getMessage())
            ->withInput();

    } catch (\Exception $e) {

        return redirect()
            ->back()
            ->with('error', 'Something went wrong: ' . $e->getMessage())
            ->withInput();
    }
}

public function destroy($id)
{
    try {

        $coupon = Coupon::findOrFail($id);

        $coupon->delete();

        return redirect()
            ->route('admin.coupons.index')
            ->with('success', 'Coupon deleted successfully.');

    } catch (\Illuminate\Database\QueryException $e) {

        return redirect()
            ->route('admin.coupons.index')
            ->with('error', 'Database Error: ' . $e->getMessage());

    } catch (\Exception $e) {

        return redirect()
            ->route('admin.coupons.index')
            ->with('error', 'Something went wrong: ' . $e->getMessage());
    }
}
}
