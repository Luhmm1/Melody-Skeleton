<?php

namespace App\Handlers;

use DI\Container;
use Melody\Handlers\AbstractErrorHandler;
use Psr\Http\Message\ResponseInterface;
use Throwable;
use Twig\Environment;

class ErrorHandler extends AbstractErrorHandler
{
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function handle(Throwable $throwable): ResponseInterface
    {
        $response = $this->responseFactory->createResponse($throwable->getCode());

        /** @var Environment $twig */
        $twig = $this->container->get(Environment::class);

        $response->getBody()->write($twig->render('errors.twig', [
            'code' => $throwable->getCode(),
            'message' => $throwable->getMessage()
        ]));

        return $response;
    }
}
