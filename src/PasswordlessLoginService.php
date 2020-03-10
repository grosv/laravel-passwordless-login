<?php

namespace Grosv\LaravelPasswordlessLogin;

use Grosv\LaravelPasswordlessLogin\Traits\PasswordlessLogable;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Str;

/**
 * Service class to keep the controller clean.
 */
class PasswordlessLoginService
{
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
     * Checks if this use class uses the PasswordlessLogable trait.
     *
     * @param User $user
     * @return bool
     */
    public function usesTrait(User $user): bool
    {
        $traits = class_uses($user, true);

        return in_array(PasswordlessLogable::class, $traits);
    }
}
