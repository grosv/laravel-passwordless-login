<?php

namespace Grosv\LaravelPasswordlessLogin\Models\Models;

use Grosv\LaravelPasswordlessLogin\Traits\Passwordless;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Passwordless;
    protected $table = 'users';
    protected $fillable = ['name', 'email', 'password', 'phone'];
}
