<?php

namespace App\models;

use App\core\db\DBModel;

class Permission extends DBModel
{
    public string $name;
    public string $slug;

    public function tableName(): string
    {
        return "permissions";
    }

    public function attributes(): array
    {
        return ["name", "slug"];
    }

    public static function primaryKey(): string
    {
        return "id";
    }
}