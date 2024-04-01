<?php

namespace App\Http\Middleware\External;

use Closure;

class SetDefaultAuthGuard
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @param mixed                    $guardName
     * @param mixed                    $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (in_array($guard, array_keys(config('auth.guards')))) {
            app('auth')->shouldUse($guard);
        }

        return $next($request);
    }
}
