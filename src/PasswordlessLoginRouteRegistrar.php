<?php

namespace Grosv\LaravelPasswordlessLogin;

use Illuminate\Contracts\Routing\Registrar;

class PasswordlessLoginRouteRegistrar
{
    /**
     * @var \Grosv\LaravelPasswordlessLogin\PasswordlessLoginOptions
     */
    protected $options;

    /**
     * @var \Illuminate\Contracts\Routing\Registrar
     */
    protected $router;

    /**
     * PasswordlessLoginRouter constructor.
     *
     * @param \Grosv\LaravelPasswordlessLogin\PasswordlessLoginOptions $options
     * @param \Illuminate\Contracts\Routing\Registrar                  $router
     */
    public function __construct(PasswordlessLoginOptions $options, Registrar $router)
    {
        $this->options = $options;
        $this->router = $router;
    }

    public function register()
    {
        $this->router
            ->get($this->options->loginRoute().'/{expires}/{uid}', [PasswordlessLoginController::class, 'login'])
            ->name($this->options->loginRouteName());
    }
}
