<?php

namespace App\Http\Middleware\External;

use Closure;

class Redirection
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $url = $request->fullUrl();
        if ($redirection = \App\Models\Redirection::isActive()->where('from', $url)->latest()->first()) {
            return redirect()->to($redirection->to, $redirection->type);
        }
        return $next($request);
    }
}
