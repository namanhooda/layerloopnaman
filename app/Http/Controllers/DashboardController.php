<?php

namespace App\Http\Controllers;
use App\Services\GoogleAnalyticsService;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(Request $request,GoogleAnalyticsService $analytics)
    {
        $report = $analytics->getReport();
        return view('dashboard', compact('report'));
    }
}
