<?php

declare(strict_types=1);

namespace App\core\singletons;

class Singleton
{
    private static array $instances = [];

    public static function getInstance(): object
    {
        $class = static::class;
        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new static();
        }
        return self::$instances[$class];
    }
}
