<?php

namespace Grosv\LaravelPasswordlessLogin;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string generate(Authenticatable $user)
 *
 * @see \Grosv\LaravelPasswordlessLogin\PasswordlessLoginUrlGenerator
 */
class PasswordlessLogin extends Facade
{
    /**
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     *
     * @return \Grosv\LaravelPasswordlessLogin\LoginUrl
     */
    public static function forUser(Authenticatable $user)
    {
        return new LoginUrl($user);
    }

    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'passwordless-login';
    }
}
