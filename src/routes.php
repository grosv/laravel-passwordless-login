<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get(config('laravel-passwordless-login.login_route').'/{expires}/{uid}', function (Request $request) {
    abort_if(!$request->hasValidSignature(), 401);

    $user_model = config('laravel-passwordless-login.user_model');
    Auth::login($user_model::find($request->uid), 'laravel-passwordless-login.remember_login');
    redirect(config('laravel-passwordless-login.redirect_on_success'));
})->name(config('laravel-passwordless-login.login_route_name'));

Route::get('/laravel_passwordless_login_redirect_test_route', function (Request $request) {
    return response()->noContent(204);
});
