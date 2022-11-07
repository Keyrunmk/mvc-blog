<?php

declare(strict_types=1);

namespace App\core\singletons;

use App\core\exception\DependencyException;

class DependencyResolver extends Dependency
{
    public static function resolve(string $className): object
    {
        // Inspect the class that we are trying to get from the controller
        $reflectionClass = new \ReflectionClass($className);

        if (!$reflectionClass->isInstantiable()) {
            throw new DependencyException("class $className is not instantiable");
        }

        // Inspect the construcotr of the class
        $constructor = $reflectionClass->getConstructor();

        if (!$constructor) {
            // $reflectionClass->newInstance();
            return new $className();
        }

        // Inspect the constructor parameters (dependencies)
        $parameters = $constructor->getParameters();

        if (!$parameters) {
            return new $className();
        }

        // If the constructor parameter is a class then try to resolve that using the container
        $dependencies = array_map(
            function (\ReflectionParameter $param) use ($className) {
                $name = $param->getName();
                $type = $param->getType();

                if (!$type) {
                    throw new DependencyException("Failed to resolve class $className because param $name is a missing a type hint");
                }

                if ($type instanceof \ReflectionUnionType) {
                    throw new DependencyException("Failed to resolve class $className because of union type for param $name");
                }

                if ($type instanceof \ReflectionNamedType && !$type->isBuiltin()) {
                    return self::get($type->getName());
                }

                throw new DependencyException("Failed to resolve class $className because of invalid class name param $name");
            },
            $parameters
        );

        //create new class instance from arguments
        return $reflectionClass->newInstanceArgs($dependencies);
    }
}