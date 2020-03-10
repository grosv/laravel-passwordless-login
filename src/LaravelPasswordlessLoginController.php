<?php

namespace Grosv\LaravelPasswordlessLogin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class LaravelPasswordlessLoginController extends Controller
{
    /**
     * Handles login from the signed route.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function login(Request $request)
    {
        abort_if(!$request->hasValidSignature(), 401);

        $user_model = config('laravel-passwordless-login.user_model');

        Auth::guard(config('laravel-passwordless-login.user_guard'))
            ->login($user_model::find($request->uid), 'laravel-passwordless-login.remember_login');

        return redirect($request->redirect_to);
    }

    /**
     * Redirect testing.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectTestRoute()
    {
        return response()->noContent(204);
    }

    /**
     * Redirect override testing.
     *
     * @return \Illuminate\Http\Response
     */
    public function overrideTestRoute()
    {
        return response()->noContent(200);
    }
}
