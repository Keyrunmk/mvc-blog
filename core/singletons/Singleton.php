<?php

declare(strict_types=1);

namespace App\core\singletons;

abstract class Singleton
{
    // Store instances
    private static array $instances = [];

    /**
     * Get stored instance if not set
     *
     * @return object
     */
    public static function getInstance(array $params = null): object
    {
        $class = static::class;
        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new static($params);
        }
        return self::$instances[$class];
    }
}
