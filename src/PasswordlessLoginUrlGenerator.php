<?php

namespace Grosv\LaravelPasswordlessLogin;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Routing\UrlGenerator;

class PasswordlessLoginUrlGenerator
{
    /**
     * @var \Grosv\LaravelPasswordlessLogin\PasswordlessLoginOptions
     */
    protected $options;

    /**
     * @var \Illuminate\Contracts\Routing\UrlGenerator|\Illuminate\Routing\UrlGenerator
     */
    protected $url;

    /**
     * PasswordlessLoginUrlGenerator constructor.
     *
     * @param \Grosv\LaravelPasswordlessLogin\PasswordlessLoginOptions $options
     * @param \Illuminate\Contracts\Routing\UrlGenerator               $url
     */
    public function __construct(PasswordlessLoginOptions $options, UrlGenerator $url)
    {
        $this->options = $options;
        $this->url = $url;
    }

    /**
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     *
     * @return string
     */
    public function generate(Authenticatable $user)
    {
        return $this->url->temporarySignedRoute(
            $this->options->loginRouteName(),
            now()->addMinutes($this->options->loginRouteExpires()),
            ['uid' => $user->getAuthIdentifier()]
        );
    }
}
