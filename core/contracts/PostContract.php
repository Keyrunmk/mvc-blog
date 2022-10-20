<?php

namespace app\core\contracts;

use app\models\Post;

interface PostContract
{
    public function listPosts(array $columns = ["*"], string $order = "id", string $sort = "desc"): mixed;

    public function findPostById(int $id): mixed;

    public function createPost(array $data): mixed;

    public function updatePost(array $data, int $id): mixed;

    public function deletePost(int $id): mixed;
}
