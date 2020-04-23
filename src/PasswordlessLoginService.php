<?php

namespace Grosv\LaravelPasswordlessLogin;

use Grosv\LaravelPasswordlessLogin\Traits\PasswordlessLogin;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Service class to keep the controller clean.
 */
class PasswordlessLoginService
{
    /**
     * @var User
     */
    public $user;

    /**
     * @var string
     */
    private $cacheKey;

    public function __construct()
    {
        $this->user = $this->getUser();
        $this->cacheKey = \request('user_type').\request('expires');
    }

    /**
     * Converts a class slug into a full class name.
     *
     * @param string $classSlug
     *
     * @return string
     */
    public function getUserClass(string $classSlug)
    {
        $slashedName = str_replace('-', '\\', $classSlug);

        return Str::title($slashedName);
    }

    /**
     * Converts the user class into a slug to use for the route.
     *
     * @param User $user
     *
     * @return string
     */
    public function getFormattedUserClass(User $user): string
    {
        $userClassName = get_class($user);
        $formattedName = str_replace('\\', '-', $userClassName);

        return Str::slug($formattedName);
    }

    /**
     * Checks if this use class uses the PasswordlessLogable trait.
     *
     * @return bool
     */
    public function usesTrait(): bool
    {
        $traits = class_uses($this->user, true);

        return in_array(PasswordlessLogin::class, $traits);
    }

    /**
     * Get the user from the request.
     *
     * @return mixed
     */
    public function getUser()
    {
        if (\request()->has('user_type')) {
            $userModel = $this->getUserClass(request('user_type'));

            return $userModel::findOrFail(request('uid'));
        }
    }

    /**
     * Caches this request.
     *
     * @param Request $request
     *
     * @throws \Exception
     */
    public function cacheRequest(Request $request)
    {
        if ($this->usesTrait()) {
            $routeExpiration = $this->user->login_route_expires_in;
        } else {
            $routeExpiration = config('laravel-passwordless-login.login_route_expires');
        }

        cache()->remember($this->cacheKey, $routeExpiration * 60, function () use ($request) {
            return $request->url();
        });
    }

    /**
     * Checks if this request has been made yet.
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return bool
     */
    public function requestIsNew(): bool
    {
        if ($this->usesTrait()) {
            $loginOnce = $this->user->login_use_once;
        } else {
            $loginOnce = config('laravel-passwordless-login.login_use_once');
        }

        if (!$loginOnce || !cache()->has($this->cacheKey)) {
            return true;
        } else {
            return false;
        }
    }
}
