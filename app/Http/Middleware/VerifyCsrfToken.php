<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '7508678190:AAGhG6Q2QtFC-HtQs3Vy-gAxWIhwwqV-z0g/webhook/*'
          //'webhook/*'
    ];
}