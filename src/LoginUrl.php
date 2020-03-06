<?php

namespace Grosv\LaravelPasswordlessLogin;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;

class LoginUrl
{
    /**
     * @var User
     */
    private $user;
    /**
     * @var \Illuminate\Config\Repository
     */
    private $route_name;
    /**
     * @var \Carbon\Carbon
     */
    private $route_expires;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->route_name = config('laravel-passwordless-login.login_route_name');
        $this->route_expires = now()->addMinutes(config('laravel-passwordless-login.login_route_expires'));
    }

    public function generate()
    {
        return URL::temporarySignedRoute(
            $this->route_name,
            $this->route_expires,
            ['uid' => $this->user->id]
        );
    }
}
