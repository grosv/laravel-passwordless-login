<?php


namespace Grosv\LaravelPasswordlessLogin\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException as Exception;

class InvalidSignatureException extends Exception
{
    public function __construct()
    {
        parent::__construct(401, 'Invalid signature.');
    }
}
