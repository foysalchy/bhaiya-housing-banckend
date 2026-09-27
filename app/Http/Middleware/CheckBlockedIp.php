<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\BlockedIp;

class CheckBlockedIp
{
    public function handle(Request $request, Closure $next)
    {
        if (BlockedIp::where('ip_address', $request->ip())->exists()) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['errors' => ['message' => ['Your IP has been blocked due to malicious activity.']]], 403);
            }
            return redirect()->back()->withErrors(['message' => 'Your IP has been blocked due to malicious activity.']);
        }

        return $next($request);
    }
}

