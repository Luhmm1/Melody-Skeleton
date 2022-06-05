<?php

namespace App;

use App\Exceptions\InvalidMiddlewareException;
use App\Handlers\ErrorHandler;
use DI\Container;
use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Melody\Application;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

class Kernel
{
    private Container $dependencies;

    public function load(): void
    {
        $this->loadDotenv();
        $this->loadSettings();
        $this->loadDependencies();

        /** @var ServerRequestInterface $request */
        $request = $this->dependencies->get(ServerRequestInterface::class);

        /** @var ResponseFactoryInterface $responseFactory */
        $responseFactory = $this->dependencies->get(ResponseFactoryInterface::class);

        $app = new Application($request, $responseFactory);

        $this->loadErrorHandler($app);
        $this->loadMiddleware($app);

        $app->run();
    }

    private function loadDotenv(): void
    {
        Dotenv::createImmutable(__DIR__ . '/..')->load();
    }

    private function loadSettings(): void
    {
        Settings::set((require __DIR__ . '/Configs/settings.php')());
    }

    private function loadDependencies(): void
    {
        $containerBuilder = new ContainerBuilder();

        if (Settings::getBool('phpdi.cache.enabled')) {
            $containerBuilder->enableCompilation(Settings::getString('phpdi.cache.dirPath'));
        }

        $containerBuilder->addDefinitions((require __DIR__ . '/Configs/dependencies.php')());

        $this->dependencies = $containerBuilder->build();
    }

    private function loadErrorHandler(Application $app): void
    {
        $app->setErrorHandler(new ErrorHandler($this->dependencies));
    }

    private function loadMiddleware(Application $app): void
    {
        $middleware = (require __DIR__ . '/Configs/middleware.php')();

        foreach ($middleware as $m) {
            $module = $this->dependencies->get($m);

            if (!$module instanceof MiddlewareInterface) {
                throw new InvalidMiddlewareException(
                    'The definition of ' . $m . ' must return an instance of MiddlewareInterface.'
                );
            }

            $app->addMiddleware($module);
        }
    }
}
