<?php

declare(strict_types=1);

namespace app\core\singletons;

use app\core\exception\ContainerException;  

class containerSingleton
{
    private static $instances = [];

    private array $entries = [];

    public static function getInstance()
    {
        $subClass = static::class;
        if (!isset(self::$instances[$subClass])) {
            self::$instances[$subClass] = new static();
        }
        return self::$instances[$subClass];
    }

    public function get(string $className): mixed
    {
        if ($this->has($className)) {
            $entry = $this->entries[$className];

            if (is_callable($entry)) {
                return $entry($this);
            }

            $className = $entry;
        }
        return $this->resolve($className);
    }

    public function has(string $className): bool
    {
        return isset($this->entries[$className]);
    }

    public function set(string $className, string $concreteClassName): void
    {
        $this->entries[$className] = $concreteClassName;
    }

    public function resolve(string $className): mixed
    {
        // Inspect the class that we are trying to get from the controller
        $reflectionClass = new \ReflectionClass($className);

        if (!$reflectionClass->isInstantiable()) {
            throw new ContainerException("class $className is not instantiable");
        }

        // Inspect the construcotr of the class
        $constructor = $reflectionClass->getConstructor();

        if (!$constructor) {
            // $reflectionClass->newInstance();
            return new $className;
        }

        // Inspect the constructor parameters (dependencies)
        $parameters = $constructor->getParameters();

        if (!$parameters) {
            return new $className;
        }

        // If the constructor parameter is a class then try to resolve that using the container
        $dependencies = array_map(
            function (\ReflectionParameter $param) use ($className) {
                $name = $param->getName();
                $type = $param->getType();

                if (!$type) {
                    throw new ContainerException("Failed to resolve class $className because param $name is a missing a type hint");
                }

                if ($type instanceof \ReflectionUnionType) {
                    throw new ContainerException("Failed to resolve class $className because of union type for param $name");
                }

                if ($type instanceof \ReflectionNamedType && !$type->isBuiltin()) {
                    return $this->get($type->getName());
                }

                throw new ContainerException("Failed to resolve class $className because of invalid class name param $name");
            },
            $parameters
        );
        
        //create new class instance from arguments
        return $reflectionClass->newInstanceArgs($dependencies);
    }
}
