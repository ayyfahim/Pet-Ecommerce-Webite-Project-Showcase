<?php

namespace App\Http\Middleware\External;

use Closure;

class CheckForApiHeaderExistence
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $request->headers->contains('accept', 'application/json')
                ? $next($request)
                : abort(400, 'missing (accept : application/json header)');
    }
}
