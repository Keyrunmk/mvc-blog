<?php

declare(strict_types=1);

namespace App\core;

use Closure;

class Router
{
    protected static array $prefix = [];

    protected static array $routeMiddlewares = [];

    // Store routes
    protected static array $routes = [];

    public static function group(array $data, Closure $closure): mixed
    {
        if (in_array("prefix", array_keys($data))) {
            self::$prefix[] = trim($data["prefix"], "/");
            if (in_array("middleware", array_keys($data))) {
                self::$routeMiddlewares[] = $data["middleware"];
            }
            call_user_func($closure);
            array_pop(self::$prefix);
            array_pop(self::$routeMiddlewares);
            return true;
        }
        return call_user_func($closure);
    }

    public static function get(string $path, array|Closure|string $callback): void
    {
        self::registerRoute("get", $path, $callback);
    }

    public static function post(string $path, array $callback): void
    {
        self::registerRoute("post", $path, $callback);
    }

    public static function registerRoute(string $methodName, $path, $callback): void
    {
        if (self::$prefix) {
            self::$routes[$methodName]["/" . implode("/", self::$prefix) . $path] = self::addCallback($callback);
        } else {
            self::$routes[$methodName][$path] = self::addCallback($callback);
        }
    }

    private static function addCallback($callback): array
    {
        if (self::$routeMiddlewares) {
            return [
                "callback" => $callback,
                "middleware" => self::$routeMiddlewares,
            ];
        }
        return $callback;
    }
}
