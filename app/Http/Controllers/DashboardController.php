<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function ecomDashboard(Request $request)
    {
        return view('admin.ecom-index');
    }
}
