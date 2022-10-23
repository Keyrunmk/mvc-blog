<?php

namespace App\core\repositories;

use App\core\contracts\CategoryPostContract;
use App\core\exception\CommonException;
use App\models\CategoryPost;
use Exception;

class CategoryPostRepository extends BaseRepository implements CategoryPostContract
{
    protected CategoryPost $model;

    public function __construct(CategoryPost $model)
    {
        $this->model = new CategoryPost();
    }

    public function findCategoryPostById(int $id): mixed
    {
        try {
            return $this->findOneOrFail($id);
        } catch (Exception $e) {
            $exception = new CommonException($e);
            throw $exception->dump();
        }
    }

    public function createCategoryPost(array $data): mixed
    {
        try {
            return $this->save($data);;
        } catch (Exception $e) {
            $exception = new CommonException($e);
            throw $exception->dump();
        }
    }

    public function updateCategoryPost(array $data, int $id): mixed
    {
        try {
            return $this->update($data, $id);
        } catch (Exception $e) {
            $exception = new CommonException($e);
            throw $exception->dump();
        }
    }

    public function deleteCategoryPost(int $id): mixed
    {
        try {
            $category = $this->findCategoryPostById($id);
            return $this->delete($category->id);
        } catch (Exception $e) {
            $exception = new CommonException($e);
            throw $exception->dump();
        }
    }
}
