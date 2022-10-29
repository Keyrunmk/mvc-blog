<?php

namespace App\core\contracts;

interface CategoryPostContract
{
    public function createCategoryPost(array $data): mixed;

    public function updateCategoryPost(array $data, int $id): mixed;

    public function deleteCategoryPost(int $id): mixed;
}
