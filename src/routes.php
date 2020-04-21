<?php

use Grosv\LaravelPasswordlessLogin\LaravelPasswordlessLoginController;
use Illuminate\Support\Facades\Route;

Route::get(
    config('laravel-passwordless-login.login_route').'/{uid}',
    [LaravelPasswordlessLoginController::class, 'login']
)->middleware('web')->name(config('laravel-passwordless-login.login_route_name'));

Route::get('/laravel_passwordless_login_redirect_test_route', [LaravelPasswordlessLoginController::class, 'redirectTestRoute'])->middleware('auth');
Route::get('/laravel_passwordless_login_redirect_overridden_route', [LaravelPasswordlessLoginController::class, 'redirectTestRoute'])->middleware('auth');
