<?php

namespace App\Http\Middleware\External;

use Closure;

class ConfirmUserVerification
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
        $user = auth()->user();

        if (!$user->hasVerifiedMobile() || !$user->hasVerifiedEmail()) {
            return $request->expectsJson()
                ? abort(503, 'please verify your account first')
                : redirect()->route('verification.notice');
        }

        return $next($request);
    }
}
