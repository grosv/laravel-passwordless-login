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
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function login(Request $request)
    {
        abort_if(!$request->hasValidSignature(), 401);

        $user_model = $this->passwordlessLoginService->getUserClass($request->user_type);

        $user = $user_model::find($request->uid);

        $usesTrait = $this->passwordlessLoginService->usesTrait($user);

        $guard = $usesTrait ? $user->getGuard() : config('laravel-passwordless-login.user_guard');
        $rememberLogin = $usesTrait ? $user->shouldRememberLogin() : config('laravel-passwordless-login.remember_login');
        $redirectUrl = $usesTrait ? $user->getRedirectUrl() : ($request->redirect_to ?: config('laravel-passwordless-login.redirect_on_success'));

        Auth::guard($guard)
            ->login($user, $rememberLogin);

        return redirect($redirectUrl);
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
