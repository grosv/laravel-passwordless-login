<?php


namespace Grosv\LaravelPasswordlessLogin;

use Illuminate\Foundation\Auth\User;

/**
 * The class used by \Grosv\LaravelPasswordlessLogin\PasswordlessLoginFacade
 *
 * Class PasswordlessLogin
 * @package Grosv\LaravelPasswordlessLogin
 */
class PasswordlessLogin
{
    private $loginUrl;

    public function forUser(User $user)
    {
        $this->loginUrl = new LoginUrl($user);
        return $this;
    }

    public function generate()
    {
        return $this->loginUrl->generate();
    }
}
