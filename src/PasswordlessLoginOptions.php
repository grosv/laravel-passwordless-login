<?php

namespace Grosv\LaravelPasswordlessLogin;

class PasswordlessLoginOptions
{
    /**
     * @var array
     */
    protected $config;

    /**
     * PasswordlessLoginOptions constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return string
     */
    public function userModel()
    {
        return $this->config['user_model'];
    }

    /**
     * @return string
     */
    public function userGuard()
    {
        return $this->config['user_guard'];
    }

    /**
     * @return bool
     */
    public function rememberLogin()
    {
        return $this->config['remember_login'];
    }

    /**
     * @return string
     */
    public function loginRoute()
    {
        return $this->config['login_route'];
    }

    /**
     * @return string
     */
    public function loginRouteName()
    {
        return $this->config['login_route_name'];
    }

    /**
     * @return int
     */
    public function loginRouteExpires()
    {
        return (int) $this->config['login_route_expires'];
    }

    /**
     * @return string
     */
    public function redirectOnSuccess()
    {
        return $this->config['redirect_on_success'];
    }
}
