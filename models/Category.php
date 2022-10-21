<?php

declare(strict_types=1);

namespace app\models;

use app\core\db\DBModel;

class Category extends DBModel
{
    public string $name;
    public string $description;

    public function tableName(): string
    {
        return 'categories';
    }

    public function attributes(): array
    {
        return ['name', 'description'];
    }

    public static function primaryKey(): string
    {
        return 'id';
    }
}   