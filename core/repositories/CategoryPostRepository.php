<?php

namespace App\core\repositories;

use App\core\contracts\CategoryPostContract;
use App\models\CategoryPost;
use Exception;
use Throwable;

class CategoryPostRepository extends BaseRepository implements CategoryPostContract
{
    protected CategoryPost $model;

    public function __construct()
    {
        $this->model = new CategoryPost();
    }

    public function findCategoryPostById(int $id): mixed
    {
        try {
            return $this->findOneOrFail($id);
        } catch (Exception | Throwable $e) {
            throw $e;
        }
    }

    public function createCategoryPost(array $data): mixed
    {
        try {
            return $this->save($data);;
        } catch (Exception | Throwable $e) {
            throw $e;
        }
    }

    public function updateCategoryPost(array $data, int $id): mixed
    {
        try {
            return $this->update($data, $id);
        } catch (Exception | Throwable $e) {
            throw $e;
        }
    }

    public function deleteCategoryPost(int $id): mixed
    {
        try {
            $category = $this->findCategoryPostById($id);
            return $this->delete($category->id);
        } catch (Exception | Throwable $e) {
            throw $e;
        }
    }
}
