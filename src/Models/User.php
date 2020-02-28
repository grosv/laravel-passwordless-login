<?php

namespace Grosv\LaravelPasswordlessLogin\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = ['name', 'email', 'password', 'phone'];
}
