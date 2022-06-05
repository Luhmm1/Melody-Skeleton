<?php

namespace App\Utils;

use App\Settings;

class Cookie
{
    public static function exists(string $name): bool
    {
        return isset($_COOKIE[$name]);
    }

    public static function get(string $name): ?string
    {
        return $_COOKIE[$name] ?? null;
    }

    public static function create(string $name, string $value, int $expires): bool
    {
        /** @phpstan-ignore-next-line */
        return setcookie($name, $value, array_merge(Settings::getArray('cookies'), [
            'expires' => $expires
        ]));
    }

    public static function delete(string $name): bool
    {
        return self::create($name, '', time() - 3600);
    }
}
