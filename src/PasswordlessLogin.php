<?php


namespace Grosv\LaravelPasswordlessLogin;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Facade;

/**
 * @method \Grosv\LaravelPasswordlessLogin\PasswordlessLoginManager forUser(User $user)
 * @method string generate()
 *
 * @package Grosv\LaravelPasswordlessLogin
 */
class PasswordlessLogin extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'passwordless-login';
    }

}
