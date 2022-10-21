<?php

declare(strict_types=1);

namespace app\models;

use app\core\db\DBModel;

class Post extends DBModel
{
    public string $name = '';
    public string $status = '';

    public function tableName(): string
    {
        return 'posts';
    }

    public function attributes(): array
    {
        return ['name', 'status'];
    }

    public static function primaryKey(): string
    {
        return 'id';
    }
}