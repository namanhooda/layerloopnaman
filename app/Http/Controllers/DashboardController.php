<?php

namespace App\Http\Controllers;
use App\Services\GoogleAnalyticsService;

use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use DB;
use App\Models\Cart;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(Request $request, GoogleAnalyticsService $analytics)
{
    $cartProducts = DB::table('carts')
    ->select('product_id')
    ->selectRaw("
        COUNT(DISTINCT COALESCE(
            CONCAT('user:', user_id),
            CONCAT('guest:', system_id)
        )) as total_users
    ")
    ->groupBy('product_id')
    ->orderByDesc('total_users')
        ->take(5)
    ->get();
    $latestOrders = Order::with('user')->where('shipment_from', 'website')
        ->latest()
        ->take(5)
        ->get();
    $order   = Order::query();
    $product = Product::query();
    $user    = User::query();

    // Selected month
    $selectedMonth = $request->month;

    if ($selectedMonth) {
        // Selected month: 1st day to last day of selected month
        $monthStart = now()->setMonth((int) $selectedMonth)->startOfMonth();
        $monthEnd   = now()->setMonth((int) $selectedMonth)->endOfMonth();
    } else {
        // No month selected: Current month
        $monthStart = now()->startOfMonth();
        $monthEnd   = now()->endOfMonth();
    }

    $totalSaleThisMonth = (clone $order)
        ->whereBetween('created_at', [
            $monthStart,
            $monthEnd
        ])
        ->where('status', 'delivered')
        ->sum('total');

    $arrayData = [
        'totalsalethismonth' => $totalSaleThisMonth,
        'totalOrders'        => (clone $order)->count(),
        'totalUsers'         => (clone $user)->count(),
        'totalProduct'       => (clone $product)->count(),
        'totalSale'          => (clone $order)
            ->where('status', 'delivered')
            ->sum('total'),
    ];

    $report = collect($analytics->getReport())
        ->sortByDesc(function ($row) {
            return $row->getDimensionValues()[0]->getValue();
        })
        ->values();

    return view('dashboard', compact(
        'report',
        'arrayData',
        'selectedMonth',
        'latestOrders',
        'cartProducts'
    ));
}

}
