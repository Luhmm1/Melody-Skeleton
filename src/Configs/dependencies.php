<?php

namespace App\Configs;

use App\Middleware\SessionMiddleware;
use App\Settings;
use App\Utils\Twig\UrlExtension;
use DI\Container;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Luhmm1\ViaRouter\ViaRouterMiddleware;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

use function DI\get;

return fn(): array => [
    EntityManager::class => function (): EntityManager {
        /** @var array<string, string> $database */
        $database = Settings::getArray('doctrine.database');

        $config = ORMSetup::createAttributeMetadataConfiguration(
            [__DIR__ . '/../Database/Entities'],
            Settings::getString('environment') === 'dev',
            __DIR__ . '/../../storage/proxies'
        );

        return EntityManager::create($database, $config);
    },
    Environment::class => function (): Environment {
        $loader = new FilesystemLoader(Settings::getString('twig.templatesPath'));

        $twig = new Environment($loader, [
            'debug' => Settings::getString('environment') === 'dev',
            'cache' => Settings::getBool('twig.cache.enabled') ? Settings::getString('twig.cache.dirPath') : false
        ]);

        if (Settings::getString('environment') === 'dev') {
            $twig->addExtension(new DebugExtension());
        }

        $twig->addExtension(new UrlExtension());

        return $twig;
    },
    ResponseFactoryInterface::class => get(Psr17Factory::class),
    ServerRequestInterface::class => function (Psr17Factory $psr17Factory): ServerRequestInterface {
        return (new ServerRequestCreator($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory))->fromGlobals();
    },

    // Middleware
    SessionMiddleware::class => function (): SessionMiddleware {
        return new SessionMiddleware();
    },
    ViaRouterMiddleware::class => function (Container $container): ViaRouterMiddleware {
        /** @var array<class-string> $controllers */
        $controllers = Settings::getArray('router.controllers');

        return new ViaRouterMiddleware($container, $controllers, [
            'cacheDisabled' => !Settings::getBool('router.cache.enabled'),
            'cacheFile' => Settings::getString('router.cache.filePath')
        ]);
    }
];
