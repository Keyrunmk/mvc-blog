<?php

namespace App\core\contracts;

interface CategoryContract
{
    public function listCategories(array $columns = ["*"], string $order = "id", string $sort = "desc"): mixed;

    public function findCategoryById(int $id): mixed;

    public function createCategory(array $params): bool;

    public function updateCategory(array $params, int $id): mixed;

    public function deleteCategory(int $id): mixed;
}
