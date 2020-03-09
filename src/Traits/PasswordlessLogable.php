<?php

namespace Grosv\LaravelPasswordlessLogin\Traits;

/**
 * Logs in a user without a password.
 */
trait PasswordlessLogable
{
    /**
     * Returns the guard set for this user.
     *
     * @return string
     */
    public function getGuard(): string
    {
        return config('laravel-passwordless-login.user_guard');
    }

    /**
     * Whether a user should be remembered on login.
     *
     * @return bool
     */
    public function shouldRememberLogin(): bool
    {
        return config('laravel-passwordless-login.remember_login');
    }

    /**
     * Returns the login route.
     *
     * @return string
     */
    public function getLoginRoute(): string
    {
        return config('laravel-passwordless-login.login_route');
    }

    /**
     * Returns the login route name.
     *
     * @return string
     */
    public function getLoginRouteName(): string
    {
        return config('laravel-passwordless-login.login_route_name');
    }

    /**
     * Returns the number of minutes the route will expire in from the current time.
     *
     * @return int
     */
    public function getLoginRouteExpiresIn(): int
    {
        return config('laravel-passwordless-login.login_route_expires');
    }

    /**
     * Returns the url to redirect to on successful login.
     *
     * @return string
     */
    public function getRedirectUrl(): string
    {
        return config('laravel-passwordless-login.redirect_on_success');
    }
}
