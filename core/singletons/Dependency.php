<?php

declare(strict_types=1);

namespace App\core\singletons;

class Dependency extends Singleton
{
    // Array to store dependencies
    private static array $entries = [];

    public static function get(string $className): object
    {
        if (self::has($className)) {
            $entry = self::$entries[$className];

            if (is_callable($entry)) {
                return new $entry(self::class);
            }

            $className = $entry;
        }
        return DependencyResolver::resolve($className);
    }

    public static function has(string $className): bool
    {
        return isset(self::$entries[$className]);
    }

    public function set(string $className, string $concreteClassName): void
    {
        self::$entries[$className] = $concreteClassName;
    }
}
