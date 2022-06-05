<?php

namespace App;

use App\Exceptions\Settings\InvalidPathException;
use App\Exceptions\Settings\InvalidTypeException;

class Settings
{
    /**
     * @var array<string, mixed> $settings
     */
    private static array $settings = [];

    public static function get(?string $path = null): mixed
    {
        if ($path === null) {
            return self::$settings;
        }

        $settings = self::$settings;
        $keys = explode('.', $path);

        foreach ($keys as $key) {
            if (is_array($settings) && isset($settings[$key])) {
                $settings = $settings[$key];
            } else {
                throw new InvalidPathException('This path does not lead to any settings.');
            }
        }

        return $settings;
    }

    /**
     * @return array<mixed, mixed>
     */
    public static function getArray(string $path): array
    {
        $settings = self::get($path);

        if (is_array($settings)) {
            return $settings;
        }

        throw new InvalidTypeException('This setting must be an array.');
    }

    public static function getBool(string $path): bool
    {
        $setting = self::get($path);

        if (is_bool($setting)) {
            return $setting;
        }

        throw new InvalidTypeException('This setting must be a boolean.');
    }

    public static function getFloat(string $path): float
    {
        $setting = self::get($path);

        if (is_float($setting)) {
            return $setting;
        }

        throw new InvalidTypeException('This setting must be a float.');
    }

    public static function getInt(string $path): int
    {
        $setting = self::get($path);

        if (is_int($setting)) {
            return $setting;
        }

        throw new InvalidTypeException('This setting must be an integer.');
    }

    public static function getString(string $path): string
    {
        $setting = self::get($path);

        if (is_string($setting)) {
            return $setting;
        }

        throw new InvalidTypeException('This setting must be a string.');
    }

    /**
     * @param array<string, mixed> $settings
     */
    public static function set(array $settings): void
    {
        self::$settings = $settings;
    }
}
