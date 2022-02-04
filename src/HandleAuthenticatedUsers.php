<?php

namespace Grosv\LaravelPasswordlessLogin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HandleAuthenticatedUsers
{
    public function handle(Request $request, \Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $home = class_exists(\App\Providers\RouteServiceProvider::class)
                    ? \App\Providers\RouteServiceProvider::HOME
                    : config('laravel-passwordless-login.redirect_on_success', '/');

                return redirect($request->get('redirect_to', $home));
            }
        }

        return $next($request);
    }
}
