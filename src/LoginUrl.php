<?php

namespace Grosv\LaravelPasswordlessLogin;

use Grosv\LaravelPasswordlessLogin\Traits\PasswordlessLogable;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

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

    /**
     * @var PasswordlessLoginService
     */
    private $passwordlessLoginService;

    public function __construct(User $user)
    {
        $this->user = $user;


        $this->passwordlessLoginService = new PasswordlessLoginService();

        if ($this->passwordlessLoginService->usesTrait($user))

            $this->route_expires = $user->getLoginRouteExpiresIn();
        else
            $this->route_expires = now()->addMinutes(config('laravel-passwordless-login.login_route_expires'));

        $this->route_name = config('laravel-passwordless-login.login_route_name');
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
                'uid' => $this->user->id,
                'redirect_to' => $this->redirect_url,
                'user_type' => $this->getFormattedUserClass()
            ]
        );
    }

    /**
     * Converts the user class into a slug to use for the route.
     *
     * @return string
     */
    private function getFormattedUserClass(): string
    {
        $userClassName = get_class($this->user);
        $formattedName = str_replace('\\', '-', $userClassName);
        return Str::slug($formattedName);
    }
}
