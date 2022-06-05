<?php

namespace App\Configs;

use App\Controllers\DefaultController;

const ROOT_PATH = __DIR__ . '/../..';
const PUBLIC_PATH = ROOT_PATH . '/public';
const RESOURCES_PATH = ROOT_PATH . '/resources';
const SRC_PATH = ROOT_PATH . '/src';
const STORAGE_PATH = ROOT_PATH . '/storage';

return fn(): array => [
    'environment' => $_ENV['ENVIRONMENT'],
    'assets' => [
        'publicPath' => $_ENV['ASSETS_PUBLIC_PATH'],
        'manifestPath' => PUBLIC_PATH . '/assets/manifest.json'
    ],
    'cookies' => [
        'path' => '/',
        'domain' => $_ENV['COOKIES_DOMAIN'],
        'secure' => $_ENV['COOKIES_SECURE'] === 'true',
        'httponly' => true,
        'samesite' => 'Strict'
    ],
    'doctrine' => [
        'database' => [
            'driver' => $_ENV['DATABASE_DRIVER'],
            'host' => $_ENV['DATABASE_HOST'],
            'user' => $_ENV['DATABASE_USER'],
            'password' => $_ENV['DATABASE_PASSWORD'],
            'dbname' => $_ENV['DATABASE_DBNAME'],
            'charset' => 'utf8'
        ],
        'migrations' => [
            'table_storage' => [
                'table_name' => 'doctrine_migration_versions',
                'version_column_name' => 'version',
                'version_column_length' => 1024,
                'executed_at_column_name' => 'executed_at',
                'execution_time_column_name' => 'execution_time'
            ],
            'migrations_paths' => [
                'App\Database\Migrations' => SRC_PATH . '/Database/Migrations'
            ],
            'all_or_nothing' => true,
            'transactional' => true,
            'check_database_platform' => true,
            'organize_migrations' => 'none',
            'connection' => null,
            'em' => null
        ],
        'cache' => [
            'enabled' => $_ENV['DOCTRINE_CACHE_ENABLED'] === 'true'
        ]
    ],
    'phpdi' => [
        'cache' => [
            'enabled' => $_ENV['PHPDI_CACHE_ENABLED'] === 'true',
            'dirPath' => STORAGE_PATH . '/container'
        ]
    ],
    'router' => [
        'controllers' => [
            DefaultController::class
        ],
        'cache' => [
            'enabled' => $_ENV['ROUTER_CACHE_ENABLED'] === 'true',
            'filePath' => STORAGE_PATH . '/routes.cache'
        ]
    ],
    'session' => [
        'name' => 'didactik_session',
        'savePath' => STORAGE_PATH . '/sessions'
    ],
    'twig' => [
        'templatesPath' => RESOURCES_PATH . '/templates',
        'cache' => [
            'enabled' => $_ENV['TWIG_CACHE_ENABLED'] === 'true',
            'dirPath' => STORAGE_PATH . '/twig'
        ]
    ]
];
