<?php

namespace app\core\repositories;

use app\core\contracts\CategoryContract;
use app\core\db\DBModel;
use app\core\exception\CommonException;
use app\models\Category;
use Exception;

class CategoryRepository extends BaseRepository implements CategoryContract
{
    protected Category $model;
    public function __construct(Category $model)
    {
        $this->model = new Category();
    }

    public function listCategories(array $columns = ['*'], string $order = 'id', string $sort = 'desc'): mixed
    {
        try {
            return $this->all($columns, $order, $sort);
        } catch (Exception $e) {
            $exception = new CommonException($e);
            throw $exception->dump();
        }
    }

    public function findCategoryById(int $id): mixed
    {
        try {
            return $this->findOneOrFail($id);
        } catch (Exception $e) {
            $exception = new CommonException($e);
            throw $exception->dump();
        }
    }

    public function createCategory(array $params): bool
    {
        try {
            $this->save($params);
            return true;
        } catch (Exception $e) {
            $exception = new CommonException($e);
            throw $exception->dump();
        }
    }

    public function updateCategory(array $params, int $id): mixed
    {
        try {
            return $this->update($params, $id);
        } catch (Exception $e) {
            $exception = new CommonException($e);
            throw $exception->dump();
        }
    }

    public function deleteCategory(int $id): mixed
    {
        try {
            $category = $this->findCategoryById($id);
            return $this->delete($category["id"]);
        } catch (Exception $e) {
            $exception = new CommonException($e);
            throw $exception->dump();
        }
    }
}