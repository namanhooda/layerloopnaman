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
                ->addColumn('actions', function ($user) {
                    $editUrl = route('admin.orders.show', $user->id);
                
                    $actions = '<div class="d-flex align-items-center">';
                
                    if (auth()->user()->can('users edit')) {
                        $actions .= '<a class="btn btn-icon me-1 edit-user" href="' . $editUrl . '">
                                        <i class="icon-base ti tabler-eye icon-22px"></i>
                                    </a>';
                    }
                
                    $actions .= '</div>';
                
                    return $actions;
                })
                ->rawColumns(['roles', 'actions'])
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
        $validated = $request->validate([
            'code' => 'required|unique:coupons,code|max:255',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:0',
            'min_cart_value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'max_usage' => 'required|integer|min:1',
            'is_active' => 'required|boolean',
        ]);
    
        $validated['used'] = 0; // default used to 0 on creation
    
        Coupon::create($validated);
    
        return redirect()->route('admin.coupons.index')->with('success', 'Coupon created successfully.');
    }
}
