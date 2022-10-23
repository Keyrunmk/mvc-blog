<?php

declare(strict_types=1);

namespace App\core;

abstract class Model
{
    abstract static public function primaryKey(): string;

    /**
     * Check if the given key matches the properties in child class
     */
    public function loadData(array $data): bool
    {
        foreach ($data as $key => $value) {
            if (!property_exists($this, $key)) {
                return false;
            }
            if (!$this->$key = $value) {
                return false;
            };
        }
        return true;
    }
}
