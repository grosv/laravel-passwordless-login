<?php

namespace Grosv\LaravelPasswordlessLogin;

use Illuminate\Foundation\Auth\User;
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
    /**
     * @var string
     */
    private $redirect_url;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->redirect_url = config('laravel-passwordless-login.redirect_on_success');
        $this->route_name = config('laravel-passwordless-login.login_route_name');
        $this->route_expires = now()->addMinutes(config('laravel-passwordless-login.login_route_expires'));
    }

    public function setRedirectUrl(string $redirectUrl)
    {
        $this->redirect_url = $redirectUrl;
    }

    public function generate()
    {
        return URL::temporarySignedRoute(
            $this->route_name,
            $this->route_expires,
            [
                'uid'         => $this->user->id,
                'redirect_to' => $this->redirect_url
            ]
        );
    }
}
