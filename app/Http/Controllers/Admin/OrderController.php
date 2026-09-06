<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ShiprocketService;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Address;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class OrderController extends Controller
{
public function index(Request $request)
{
    if ($request->ajax()) {

    $query = Order::with('user')
        ->orderByDesc('order_date')
        ->orderByDesc('created_at');

    return DataTables::eloquent($query)
        ->addIndexColumn()
        ->addColumn('order_code', fn ($o) =>
            '<a href="'.route('admin.orders.show', $o->id).'" class="text-success fw-bold">'.e($o->order_code).'</a>'
        )

        ->addColumn('phone', fn ($o) => $o->user?->phone ?? 'N/A')
        ->addColumn('name', fn ($o) => $o->user?->name ?? 'N/A')

        ->addColumn('order_date', fn ($o) =>
            $o->order_date?->format('d F Y') ?? 'N/A'
        )
->editColumn('payment_mod', function ($o) {

    $value = strtolower($o->payment_mod ?? 'n/a');

    $class = match ($value) {
        'prepaid' => 'badge bg-label-success',          // green
        'cod'     => 'badge bg-label-warning',           // red
        default   => 'badge bg-secondary',        // fallback
    };

    return '<span class="'.$class.'">'.strtoupper($value).'</span>';
})
        ->addColumn('total', fn ($o) => $o->total ?? 'N/A')->addColumn('shipment_from', function ($o) {

    $value = strtolower($o->shipment_from ?? 'website');

    $class = match ($value) {
        'website'     => 'badge bg-success',   // green
        'shiprocket'  => 'badge text-bg-primary',    // purple (custom)
        'nimbus'      => 'badge text-bg-dark',   // navy/blue
        'store'       => 'badge text-bg-warning', // orange
        default       => 'badge bg-secondary',
    };

    return '<span class="'.$class.'">'.ucfirst($value).'</span>';
})

        ->editColumn('status', function ($o) {
            $s = strtoupper($o->status ?? '');
            $c = match (true) {
                in_array($s, ['CANCELLED','CANCELED']) => 'bg-danger',
                $s === 'DELIVERED' => 'bg-success',
                default => 'bg-primary'
            };
            return "<span class='badge {$c}'>{$s}</span>";
        })

        // 🔍 SEARCH FIX
        ->filterColumn('phone', fn ($q,$k) =>
            $q->whereHas('user', fn ($uq) => $uq->where('phone','like',"%{$k}%"))
        )
        ->filterColumn('name', fn ($q,$k) =>
            $q->whereHas('user', fn ($uq) => $uq->where('name','like',"%{$k}%"))
        )
        ->filterColumn('order_code', fn ($q,$k) =>
            $q->where('order_code','like',"%{$k}%")
        )
        ->filterColumn('shipment_from', fn ($q,$k) =>
            $q->where('shipment_from','like',"%{$k}%")
        )

        ->rawColumns(['order_code','status','shipment_from','payment_mod'])
        ->make(true);
}


    $totalOrders = Order::query();

    $orderscount = [
        'delivered' => (clone $totalOrders)->where('status', 'Delivered')->count(),
        'cancelled' => (clone $totalOrders)->where('status', 'cancelled')->count(),
        'pending'   => (clone $totalOrders)->whereNotIn('status', ['rto','cancelled','delivered'])->count(),
        'rto' => (clone $totalOrders)->where('status', 'like', '%rto%')->count(),
    ];

    return view('admin.orders.index', compact('orderscount'));
}

    public function show(Request $request, $id)
    {
        $order = Order::find($id); 
        $orderItems = OrderItem::where('order_id', $id)->get(); 
        $user = User::find($order->user_id); 
        $address = Address::find($order->address_id); 
        return view('admin.orders.show', compact('order','orderItems','user','address'));
    }

    public function create(Request $request)
    {
        return view('admin.orders.create');
    }


public function store(Request $request)
{
    try {


  $validator = \Validator::make($request->all(), [
    'shipment_from'    => 'required|string|max:255',
    'subtotal'        => 'required|numeric|min:0',
    'shipping' => 'required|numeric|min:0',
    'total'            => 'required|numeric|min:0',
    'status'           => 'required',
    'order_date'       => 'required|date',
    'payment_status'   => 'required',
    'payment_mode'     => 'required',
    'address_id'       => 'required|exists:addresses,id',
]);

if ($validator->fails()) {
    dd($validator->errors()); // ✅ NOW THIS WILL SHOW
}

        DB::beginTransaction();

        // ✅ GENERATE ORDER CODE
        $code = 'LLORD' . str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // ✅ FETCH ADDRESS + USER SAFELY
        $address = Address::findOrFail($request->address_id);
        $user = User::find($address->user_id);
        $user_id = $user->id ?? null;

        // ✅ CREATE ORDER
        $orderarray = Order::create([
            'order_code'        => $code,
            'shipment_from'     => $request->shipment_from,
            'sub_total'         => $request->subtotal,
            'shipping_charges'  => $request->shipping,
            'total'             => $request->total,
            'status'            => $request->status,
            'order_date'        => $request->order_date,
            'payment_status'    => $request->payment_status,
            'payment_mod'      => $request->payment_mode,
            'address_id'        => $request->address_id,
            'user_id'           => $user_id,

            // ✅ IMPORTANT FIX
            'created_at'        => Carbon::parse($request->order_date),
            'updated_at'        => Carbon::parse($request->order_date),
        ]);

        if($request->products){
        foreach ($request->products as $product) {
            OrderItem::create([
                'order_id' => $orderarray->id,
                'product_id' => $product['product_id'],
                'quantity'   => $product['quantity'],
                'price'      => $product['price'],
            ]);
        }
    }



        DB::commit();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order created successfully');

    } catch (\Illuminate\Validation\ValidationException $e) {

        // ✅ VALIDATION ERROR
        return redirect()->back()
            ->withErrors($e->validator)
            ->withInput();

    } catch (\Exception $e) {

    dd($e);
        DB::rollBack();

        // ✅ LOG ERROR (VERY IMPORTANT)
        Log::error('Order Store Error: ' . $e->getMessage());

        return redirect()->back()
            ->with('error', 'Something went wrong! Please try again.')
            ->withInput();
    }
}



    public function createShipment(Order $order, $id)
    {
        $order = Order::with('itemsData')->findOrFail($id);
        $response = \App\Services\NimbusPostService::createOrder($order);
        if($response['message'] === 'Order already exists in NimbusPost') {
            return redirect()->back()->with('error', 'Order already exists in NimbusPost');
        }else{
            
            return redirect()->back()->with('success', 'Order created in NimbusPost successfully');
        }

    }
  
    public function search(Request $request)
    {
        $search = $request->search;

        $addresses = Address::query()
            ->when($search, function ($query) use ($search) {
                $query->where('first_name', 'like', "%$search%")
                    ->orWhere('last_name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('phone', 'like', "%$search%");
            })
            ->limit(20)
            ->get(['id', 'first_name', 'last_name', 'email', 'phone']);

        return response()->json($addresses);
    }



    public function addressStore(Request $request)
    {
        $request->validate([
            'first_name'     => 'required',
            'last_name'      => 'nullable',
            'country'        => 'required',
            'address_line1'  => 'required',
            'city'           => 'required',
            'state'          => 'required',
            'zip'            => 'required',
            'email'          => 'nullable|email',
            'phone'          => 'nullable'
        ]);

        // ❗ Ensure at least one exists
        if (!$request->email && !$request->phone) {
            return response()->json([
                'status' => false,
                'message' => 'Email or Phone is required'
            ], 422);
        }

        // 🔍 Find user
        $user = User::query()
            ->when($request->email, function ($q) use ($request) {
                $q->where('email', $request->email);
            })
            ->when($request->phone, function ($q) use ($request) {
                $q->orWhere('phone', $request->phone);
            })
            ->first();

        // ✅ If user not found → create new user
        if (!$user) {

            $user = User::create([
                'name'     => $request->first_name . ' ' . $request->last_name,
                'email'    => $request->email,
                'phone'    => $request->phone,
                'password' => Hash::make(Str::random(8)), // random password
            ]);
        }

        // ✅ Create Address with user_id
        $data = $request->all();
        $data['user_id'] = $user->id;

        $address = Address::create($data);


        return response()->json($address);
    }

    public function searchProdct(Request $request)
    {
        $products = Product::where('name', 'like', "%{$request->search}%")
            ->limit(20)
            ->get(['id', 'name', 'price', 'featured_image']);

        return response()->json($products);
    }
    
    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        // Delete all order items
        OrderItem::where('order_id', $order->id)->delete();

        // Delete the order
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully.');
    }

}
