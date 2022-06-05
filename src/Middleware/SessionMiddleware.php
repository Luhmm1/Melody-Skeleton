<?php

namespace App\Middleware;

use App\Settings;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SessionMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_name(Settings::getString('session.name'));
            session_save_path(Settings::getString('session.savePath'));

            /** @phpstan-ignore-next-line */
            session_set_cookie_params(array_merge(Settings::getArray('cookies'), [
                'lifetime' => 0
            ]));

            session_start();
        }

        return $handler->handle($request);
    }
}
