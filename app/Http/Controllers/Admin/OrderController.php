<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Order;
use App\Models\User;
use App\Models\Address;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $order = Order::with('user')->get(); // eager load roles

            return DataTables::of($order)
                ->addIndexColumn()
                ->addColumn('email', function ($order) {
                    return $order->user->email ?? 'N/A';
                })
                ->addColumn('total', function ($order) {
                    return $order->total ?? 'N/A';
                })
                ->editColumn('status', function ($order) {
                    return $order->status ?? 'N/A';
                })
                ->addColumn('created_at', function ($user) {
                    return $user->created_at;
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

        return view('admin.orders.index');
    }
    public function show(Request $request, $id)
    {
        $order = Order::find($id); 
        $orderItems = OrderItem::where('order_id', $id)->get(); 
        $user = User::find($order->user_id); 
        $address = Address::find($order->address_id); 
        return view('admin.orders.show', compact('order','orderItems','user','address'));
    }
}
