<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'moteles*',
        'administradores*',
        'entradas-salidas*',
        'habitaciones*',
        'iniciar-sesion*',
        'porteros*',
        'usuarios*',
    ];
}
