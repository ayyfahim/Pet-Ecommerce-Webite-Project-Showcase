<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AuthenticateFrontend extends Middleware
{

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return string
     */
    protected function redirectTo($request)
    {
        $frontend_url = config('app.frontend_url');
        return $frontend_url . '/login';
    }
}
