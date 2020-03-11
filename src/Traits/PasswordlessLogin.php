<?php

namespace Grosv\LaravelPasswordlessLogin\Traits;

/**
 * Logs in a user without a password.
 */
trait PasswordlessLogin
{
    /**
     * Returns the guard set for this user.
     *
     * @return string
     */
    public function getGuardNameAttribute(): string
    {
        return config('laravel-passwordless-login.user_guard');
    }

    /**
     * Whether a user should be remembered on login.
     *
     * @return bool
     */
    public function shouldRememberLoginAttribute(): bool
    {
        return config('laravel-passwordless-login.remember_login');
    }

    /**
     * Returns the number of minutes the route will expire in from the current time.
     *
     * @return int
     */
    public function getLoginRouteExpiresInAttribute(): int
    {
        return config('laravel-passwordless-login.login_route_expires');
    }

    /**
     * Returns the url to redirect to on successful login.
     *
     * @return string
     */
    public function getRedirectUrlAttribute(): string
    {
        return config('laravel-passwordless-login.redirect_on_success');
    }
}
