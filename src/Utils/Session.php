<?php

namespace App\Utils;

class Session
{
    public static function exists(string $path): bool
    {
        return self::get($path) !== null;
    }

    public static function get(string $path): mixed
    {
        if ($path === '') {
            return $_SESSION;
        }

        $session = $_SESSION;
        $keys = explode('.', $path);

        foreach ($keys as $key) {
            if (isset($session[$key])) {
                $session = $session[$key];
            } else {
                return null;
            }
        }

        return $session;
    }

    public static function set(string $path, mixed $value): void
    {
        if ($path === '') {
            $_SESSION = $value;

            return;
        }

        $session = &$_SESSION;
        $keys = explode('.', $path);

        foreach ($keys as $key) {
            if (!isset($session[$key]) || !is_array($session[$key])) {
                $session[$key] = [];
            }

            $session = &$session[$key];
        }

        $session = $value;
    }

    public static function add(string $path, mixed $value): void
    {
        if ($path === '') {
            $_SESSION[] = $value;

            return;
        }

        $session = &$_SESSION;
        $keys = explode('.', $path);

        foreach ($keys as $key) {
            if (!isset($session[$key]) || !is_array($session[$key])) {
                $session[$key] = [];
            }

            $session = &$session[$key];
        }

        $session[] = $value;
    }

    public static function unset(string $path): void
    {
        if ($path === '') {
            self::destroy();

            return;
        }

        $session = &$_SESSION;
        $keys = explode('.', $path);

        foreach ($keys as $i => $key) {
            if ((count($keys) - 1) === $i) {
                unset($session[$key]);

                return;
            }

            $session = &$session[$key];
        }
    }

    public static function destroy(): void
    {
        session_destroy();
    }
}
