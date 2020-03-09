<?php

namespace Grosv\LaravelPasswordlessLogin\Traits;

/**
 * Logs in a user without a password.
 */
trait PasswordlessLogable
{
    /**
     * Sets the guard of the logging user.
     *
     * Default is "web"
     *
     * @var string
     */
    protected $guard;

    /**
     * Sets whether or not to remember the logged in user.
     *
     * Default is "false"
     *
     * @var bool
     */
    protected $rememberLogin;

    /**
     * The url to be used for magic passwordless login.
     *
     * Default is "/magic-login"
     *
     * @var string
     */
    protected $loginRoute;

    /**
     * The time when the signed login route is valid in minutes.
     *
     * Default is 30
     *
     * @var int
     */
    protected $loginRouteExpires;

    /**
     * The url to redirect to if a login is successful.
     *
     * Default is "/"
     *
     * @var string
     */
    protected $redirectUrl;

    /**
     * Returns the guard set for this user.
     *
     * @return string
     */
    public function getGuard(): string
    {
        return $this->guard ?? config('laravel-passwordless-login.user_guard');
    }

    /**
     * Whether a user should be remembered on login.
     *
     * @return bool
     */
    public function shouldRememberLogin(): bool
    {
        return $this->rememberLogin ?? config('laravel-passwordless-login.remember_login');
    }

    /**
     * Returns the login route.
     *
     * @return string
     */
    public function getLoginRoute(): string
    {
        return $this->loginRoute ?? config('laravel-passwordless-login.login_route');
    }

    /**
     * Returns the number of minutes the route will expire in from the current time.
     *
     * @return int
     */
    public function getLoginRouteExpiresIn(): int
    {
        return $this->loginRouteExpires ?? config('laravel-passwordless-login.login_route_expires');
    }

    /**
     * Returns the url to redirect to on successful login.
     *
     * @return string
     */
    public function getRedirectUrl() : string
    {
        return $this->redirectUrl ?? config('laravel-passwordless-login.redirect_on_success');
    }
}
