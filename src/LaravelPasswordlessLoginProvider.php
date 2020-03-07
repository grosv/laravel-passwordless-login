<?php

namespace Grosv\LaravelPasswordlessLogin;

use Illuminate\Support\ServiceProvider;

class LaravelPasswordlessLoginProvider extends ServiceProvider
{
    /**
     * @param \Grosv\LaravelPasswordlessLogin\PasswordlessLoginRouteRegistrar $router
     */
    public function boot(PasswordlessLoginRouteRegistrar $router)
    {
        if (!$this->app->routesAreCached()) {
            $router->register();
        }

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'../config/config.php', $this->app->configPath('laravel-passwordless-login.php'),
            ], 'passwordless-login-config');
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-passwordless-login');

        $this->app->bind(PasswordlessLoginOptions::class, function ($app) {
            return new PasswordlessLoginOptions($app['config']['laravel-passwordless-login']);
        });

        $this->app->alias(PasswordlessLoginUrlGenerator::class, 'passwordless-login');
    }
}
