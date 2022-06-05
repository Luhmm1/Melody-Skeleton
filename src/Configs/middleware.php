<?php

namespace App\Configs;

use App\Middleware\SessionMiddleware;
use Luhmm1\ViaRouter\ViaRouterMiddleware;

return fn(): array => [
    SessionMiddleware::class,
    ViaRouterMiddleware::class
];
