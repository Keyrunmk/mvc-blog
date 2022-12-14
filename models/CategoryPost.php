<?php

namespace app\models;

use app\core\db\DBModel;

class CategoryPost extends DBModel
{
    public string $category_id;
    public string $post_id;

    public function tableName(): string
    {
        return 'categories_posts';
    }

    public function attributes(): array
    {
        return ['category_id', 'post_id'];
    }

    public static function primaryKey(): string
    {
        return 'id';
    }
}
