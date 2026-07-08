<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureWelfareAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
   public function handle(Request $request, Closure $next)
{
    if (auth()->user()->is_super_admin) return $next($request);

    if (!session()->has('active_welfare_id')) {
        return redirect()->route('frontend.explore')->with('error', 'Please select a welfare first.');
    }

    return $next($request);
}
}
