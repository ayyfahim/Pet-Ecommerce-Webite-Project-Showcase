<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class ManagerAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->hasManagerAccess()) {
            return $next($request);
        } elseif (Auth::check() && !Auth::user()->hasManagerAccess()) {
            abort(403);
        } else {
            return redirect()->route('admin.login');
        }
    }
}
