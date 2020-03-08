<?php

use Grosv\LaravelPasswordlessLogin\LaravelPasswordlessLoginController;
use Illuminate\Support\Facades\Route;

Route::get(
    config('laravel-passwordless-login.login_route').'/{expires}/{uid}',
    [LaravelPasswordlessLoginController::class, 'login']
)
    ->name(config('laravel-passwordless-login.login_route_name'));

Route::get('/laravel_passwordless_login_redirect_test_route', [LaravelPasswordlessLoginController::class, 'redirectTestRoute']);
