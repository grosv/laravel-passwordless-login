<?php


namespace Grosv\LaravelPasswordlessLogin;

use Illuminate\Support\Facades\Facade;

class PasswordlessLoginFacade extends  Facade
{
    protected static function getFacadeAccessor()
    {
        return 'passwordless-login';
    }

}
