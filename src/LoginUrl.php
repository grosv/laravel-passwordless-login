<?php

namespace Grosv\LaravelPasswordlessLogin;

use Grosv\LaravelPasswordlessLogin\Traits\PasswordlessLogable;
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

        if($this->usesTrait()) {
            $this->route_name = $user->getLoginRouteName();
            $this->route_expires = $user->getLoginRouteExpiresIn();
        }else{
            $this->route_name = config('laravel-passwordless-login.login_route_name');
            $this->route_expires = now()->addMinutes(config('laravel-passwordless-login.login_route_expires'));
        }
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

    /**
     * Checks if the incoming user uses the PasswordlessLogable trait.
     *
     * @return bool
     */
    private function usesTrait(): bool
    {
        $traits = class_uses($this->user, true);

        return in_array(PasswordlessLogable::class, $traits);
    }
}
