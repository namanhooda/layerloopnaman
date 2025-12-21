<?php

namespace App\Http\Controllers;
use App\Services\GoogleAnalyticsService;

use App\Models\Product;
use App\Models\Order;
use App\Models\User;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(Request $request, GoogleAnalyticsService $analytics)
    {
        $order   = Order::query();
        $product = Product::query();
        $user    = User::query();


        $totalSaleThisMonth = (clone $order)
            ->whereBetween('created_at', [
                now()->startOfMonth(),
                now()->endOfMonth()
            ])->where('status','DELIVERED')
            ->sum('total');

        $arrayData = [
            'totalsalethismonth' => $totalSaleThisMonth,
            'totalOrders'        => (clone $order)->count(),
            'totalUsers'         => (clone $user)->count(),
            'totalProduct'       => (clone $product)->count(),
            'totalSale'          => (clone $order)->where('status','DELIVERED')->sum('total'),
        ];

        $report = $analytics->getReport();

        return view('dashboard', compact('report', 'arrayData'));
    }

}
