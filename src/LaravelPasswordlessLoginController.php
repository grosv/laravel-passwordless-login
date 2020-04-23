<?php

namespace Grosv\LaravelPasswordlessLogin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class LaravelPasswordlessLoginController extends Controller
{
    /**
     * @var PasswordlessLoginService
     */
    private $passwordlessLoginService;

    /**
     * LaravelPasswordlessLoginController constructor.
     *
     * @param PasswordlessLoginService $passwordlessLoginService
     */
    public function __construct(PasswordlessLoginService $passwordlessLoginService)
    {
        $this->passwordlessLoginService = $passwordlessLoginService;
    }

    /**
     * Handles login from the signed route.
     *
     * @param Request $request
     *
     * @throws \Exception
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function login(Request $request)
    {
        abort_if(!$request->hasValidSignature() || !$this->passwordlessLoginService->requestIsNew(), 401, config('laravel-passwordless-login.invalid_signature_message'));

        $this->passwordlessLoginService->cacheRequest($request);

        $user = $this->passwordlessLoginService->user;

        $guard = $user->guard_name ?? config('laravel-passwordless-login.user_guard');

        $rememberLogin = $user->should_remember_login ?? config('laravel-passwordless-login.remember_login');

        $redirectUrl = $user->redirect_url ?? ($request->redirect_to ?: config('laravel-passwordless-login.redirect_on_success'));

        Auth::guard($guard)->login($user, $rememberLogin);

        abort_unless($user == Auth::guard($guard)->user(), 401);

        return $user->guard_name ? $user->onPasswordlessLoginSuccess($request) : redirect($redirectUrl);
    }

    /**
     * Redirect testing.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectTestRoute()
    {
        return response(Auth::user()->name, 200);
    }

    /**
     * Redirect override testing.
     *
     * @return \Illuminate\Http\Response
     */
    public function overrideTestRoute()
    {
        return response('Redirected '.Auth::user()->name, 200);
    }
}
