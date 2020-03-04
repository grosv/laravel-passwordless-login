# Laravel Passwordless Login
### A simple, safe magic login link generator for Laravel
[![Latest Version on Packagist](https://img.shields.io/packagist/v/grosv/laravel-passwordless-login.svg?style=flat-square)](https://packagist.org/packages/grosv/laravel-passwordless-login)
[![StyleCI](https://github.styleci.io/repos/243858945/shield?branch=master)](https://github.styleci.io/repos/243858945)
![Build Status](https://app.chipperci.com/projects/8c76f67e-e513-46a3-ad7a-aecb136dfa05/status/master)

This package provides a temporary signed route that logs in a user. What it does not provide is a way of actually sending the link to the route to the user. This is because I don't want to many any assumptions about how you communicate with your users.

### Installation
```shell script
composer require grosv/laravel-passwordless-login
```

### Usage
```php
use App\User;
use Grosv\LaravelPasswordlessLogin\LoginUrl;

function sendLoginLink()
{
    $user = User::find(1);

    $generator = new LoginUrl($user);
    $url = $generator->generate();

    //OR Use a Facade
    $url = PasswordlessLogin::forUser($user)->generate();

    // Send $url in an email or text message to your user
}
```

The biggest mistake I could see someone making with this package is creating a login link for one user and sending it to another. Please be careful and test your code. I don't want anyone getting mad at me for somoene else's silliness. 

### Configuration
You can publish the config file or just set the values you wan to use in your .env file:
```dotenv
LPL_USER_MODEL=App\User
LPL_REMEMBER_LOGIN=false
LPL_LOGIN_ROUTE=/magic-login
LPL_LOGIN_ROUTE_NAME=magic-login
LPL_LOGIN_ROUTE_EXPIRES=30
LPL_REDIRECT_ON_LOGIN=/
```
LPL_USER_MODEL is the the authenticatable model you are logging in (usually App\User)

LPL_REMEMBER_LOGIN is whether you want to remember the login (like the user checking Remember Me)

LPL_LOGIN_ROUTE is the route that points to the login function this package provides. Make sure you don't collide with one of your other routes.

LPL_LOGIN_ROUTE_NAME is the name of the LPL_LOGIN_ROUTE. Again, make sure it doesn't collide with any of your existing route names.

LPL_LOGIN_ROUTE_EXPIRES is the number of minutes you want the link to be good for. I recommend you set the shortest value that makes sense for your use case.

LPL_REDIRECT_ON_LOGIN is where you want to send the user after they've logged in by clicking their magic link.

### Reporting Issues

For security issues, please email me directly at ed@gros.co. For any other problems, use the issue tracker here.

### Contributing

I welcome the community's help with improving and maintaining all my packages. Just be nice to each other. Remember we're all just trying to do our best.
