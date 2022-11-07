<?php

namespace App\core\repositories;

use App\core\contracts\CategoryContract;
use App\models\Category;
use Exception;
use Throwable;

class CategoryRepository extends BaseRepository implements CategoryContract
{
    protected Category $model;
    public function __construct()
    {
        $this->model = new Category();
    }

    public function listCategories(array $columns = ['*'], string $order = 'id', string $sort = 'desc'): mixed
    {
        try {
            return $this->all($columns, $order, $sort);
        } catch (Exception | Throwable $e) {
            throw $e;
        }
    }

    public function findCategoryById(int $id): mixed
    {
        try {
            return $this->findOneOrFail($id);
        } catch (Exception | Throwable $e) {
            throw $e;
        }
    }

    public function createCategory(array $params): bool
    {
        try {
            $this->save($params);
            return true;
        } catch (Exception | Throwable $e) {
            throw $e;
        }
    }

    public function updateCategory(array $params, int $id): mixed
    {
        try {
            return $this->update($params, $id);
        } catch (Exception | Throwable $e) {
            throw $e;
        }
    }

    public function deleteCategory(int $id): mixed
    {
        try {
            $category = $this->findCategoryById($id);
            return $this->delete($category["id"]);
        } catch (Exception | Throwable $e) {
            throw $e;
        }
    }
}
