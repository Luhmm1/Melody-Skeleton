<?php

namespace App\Controllers;

use DI\Container;
use Psr\Http\Message\ResponseInterface;
use Twig\Environment;

abstract class AbstractController
{
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function json(mixed $value): ResponseInterface
    {
        /** @var ResponseInterface $response */
        $response = $this->container->get(ResponseInterface::class);

        $response->getBody()->write((string) json_encode($value));

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function redirect(string $location): ResponseInterface
    {
        /** @var ResponseInterface $response */
        $response = $this->container->get(ResponseInterface::class);

        return $response->withHeader('Location', $location);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function render(string $path, array $options = []): ResponseInterface
    {
        /** @var ResponseInterface $response */
        $response = $this->container->get(ResponseInterface::class);

        /** @var Environment $twig */
        $twig = $this->container->get(Environment::class);

        $response->getBody()->write($twig->render($path, $options));

        return $response;
    }
}
