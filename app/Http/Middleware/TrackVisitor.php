<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Models\Visitor; // Create this model/table if storing in DB

class TrackVisitor
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('visitor_tracked')) {
            Session::put('visitor_tracked', true);

            // Save visitor info to DB (optional)
            Visitor::create([
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'url'        => $request->fullUrl(),
                'visited_at' => now(),
            ]);
        }

        return $next($request);
    }
}
