<?php


namespace Grosv\LaravelPasswordlessLogin;

use Illuminate\Support\Facades\Facade;

class PasswordlessLogin extends  Facade
{
    protected static function getFacadeAccessor()
    {
        return 'passwordless-login';
    }

}
