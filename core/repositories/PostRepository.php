<?php

namespace App\core\repositories;

use App\core\contracts\PostContract;
use App\core\exception\CommonException;
use App\models\Post;
use Exception;

class PostRepository extends BaseRepository implements PostContract
{
    protected Post $model;

    public function __construct()
    {
        $this->model = new Post();
    }
    public function listPosts(array $columns = ['*'], string $order = 'id', string $sort = 'desc'): mixed
    {
        try {
            return $this->all($columns, $order, $sort);
        } catch (Exception $e) {
            $exception = new CommonException($e);
            throw $exception;
        }
    }

    public function findPostById(int $id): mixed
    {
        try {
            $result = $this->findOneOrFail($id);
            return $result;
        } catch (Exception $e) {
            $exception = new CommonException($e);
            throw $exception;
        }
    }

    public function findPostsByCategory(int $id)
    {
        try {
            $result =  $this->model->findManyToManyById("post", "category", "categories_posts",$id);
            return $result;
        } catch (Exception $e) {
            $exception = new CommonException($e);
            throw $exception;
        }
    }

    public function createPost(array $data): mixed
    {
        try {
            return $this->save($data);
        } catch (Exception $e) {
            $exception = new CommonException($e);
            throw $exception;
        }
    }

    public function updatePost(array $data, int $id): mixed
    {
        try {
            return $this->update($data, $id);
        } catch (Exception $e) {
            $exception = new CommonException($e);
            throw $exception;
        }
    }

    public function deletePost(int $id): mixed
    {
        try {
            return $this->delete($id);
        } catch (Exception $e) {
            $exception = new CommonException($e);
            throw $exception;
        }
    }
}
