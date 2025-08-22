<?php

namespace App\Http\Controllers;
use App\Services\GoogleAnalyticsService;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function ecomDashboard(Request $request,GoogleAnalyticsService $analytics)
    {
        $report = $analytics->getReport();
        dd($report);
        return view('dashboard');
    }
}
