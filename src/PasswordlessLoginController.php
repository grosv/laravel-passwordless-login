<?php

namespace Grosv\LaravelPasswordlessLogin;

use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PasswordlessLoginController
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
     * @var \Illuminate\Auth\AuthManager
     */
    protected $auth;

    /**
     * @var \Illuminate\Contracts\Routing\ResponseFactory
     */
    protected $response;

    /**
     * PasswordlessLoginController constructor.
     *
     * @param \Grosv\LaravelPasswordlessLogin\PasswordlessLoginOptions $options
     * @param \Illuminate\Contracts\Routing\UrlGenerator               $url
     * @param \Illuminate\Auth\AuthManager                             $auth
     * @param \Illuminate\Contracts\Routing\ResponseFactory            $response
     */
    public function __construct(PasswordlessLoginOptions $options, UrlGenerator $url, AuthManager $auth, ResponseFactory $response)
    {
        $this->options = $options;
        $this->url = $url;
        $this->auth = $auth;
        $this->response = $response;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $user = $this->retrieveUser($request);

        if (!$user) {
            throw new HttpException(401);
        }

        $this->auth->guard($this->options->userGuard())->login($user);

        return $this->response->redirectTo($this->options->redirectOnSuccess());
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Contracts\Auth\Authenticatable|null
     */
    protected function retrieveUser(Request $request)
    {
        if (!$this->url->hasValidSignature($request)) {
            return null;
        }

        /** @var \Illuminate\Database\Eloquent\Model|\Illuminate\Contracts\Auth\Authenticatable $instance */
        $model = $this->options->userModel();
        $instance = new $model();

        return $instance
            ->newQuery()
            ->where($instance->getAuthIdentifierName(), $request->route('uid'))
            ->first();
    }
}
