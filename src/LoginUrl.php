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

    /**
     * @var PasswordlessLoginService
     */
    private $passwordlessLoginService;

    public function __construct(User $user)
    {
        $this->user = $user;

        $this->passwordlessLoginService = new PasswordlessLoginService();

        $this->route_expires = $this->user->login_route_expires_in ?? now()->addMinutes(config('laravel-passwordless-login.login_route_expires'));

        $this->route_name = config('laravel-passwordless-login.login_route_name');
    }

    public function setRedirectUrl(string $redirectUrl)
    {
        $this->redirect_url = $redirectUrl;
    }

    public function generate()
    {
        $idField = $this->user->getKeyName() ?? 'id';

        return URL::temporarySignedRoute(
            $this->route_name,
            $this->route_expires,
            [
                'uid'           => $this->user->$idField,
                'redirect_to'   => $this->redirect_url,
                'user_type'     => $this->passwordlessLoginService->getFormattedUserClass($this->user),
            ]
        );
    }
}
