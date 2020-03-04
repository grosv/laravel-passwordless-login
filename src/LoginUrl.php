<?php

namespace Grosv\LaravelPasswordlessLogin;


use Grosv\LaravelPasswordlessLogin\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\URL;

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

        if ($this->isAuthenticatable()) {
            return URL::temporarySignedRoute(
                $this->route_name, $this->route_expires, ['uid' => $this->user->id]
            );
        }
    }

    private function isAuthenticatable()
    {
        if ($this->user instanceof Authenticatable) {
            return true;
        } else {
            throw new AuthenticationException('The model you passed as a user is unauthenticatable');
        }
    }
}
