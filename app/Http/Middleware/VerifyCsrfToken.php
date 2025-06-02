<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'login',         // Exclude /login route
        'register',      // Exclude /register route
        'login/',        // Exclude /login/ route
        'register/',     // Exclude /register/ route
        'https://di220014.fsktm.dev/login',   // Exclude full URL for login
        'https://di220014.fsktm.dev/register', // Exclude full URL for register
        'login',         // Exclude the login route with exact match
        'register',      // Exclude the register route with exact match
    ];
}

