<?php

namespace app\core\contracts;

use app\models\CategoryPost;

interface CategoryPostContract
{
    public function createCategoryPost(array $data): mixed;

    public function updateCategoryPost(array $data, int $id): mixed;

    public function deleteCategoryPost(int $id): mixed;
}
