<?php

namespace Grosv\LaravelPasswordlessLogin;

use Illuminate\Support\Str;

class UserClass
{
    public static function toSlug(string $class): string
    {
        $pieces = array_map(function (string $piece): string {
            return Str::snake($piece);
        }, explode('\\', $class));

        return implode('-', $pieces);
    }

    public static function fromSlug(string $slug): string
    {
        $pieces = array_map(function (string $piece): string {
            return ucfirst(Str::studly($piece));
        }, explode('-', $slug));

        return implode('\\', $pieces);
    }
}
