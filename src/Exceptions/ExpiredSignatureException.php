<?php


namespace Grosv\LaravelPasswordlessLogin\Exceptions;

use Exception;

class ExpiredSignatureException extends Exception
{
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        abort(401, config('laravel-passwordless-login.invalid_signature_message'));
    }
}
