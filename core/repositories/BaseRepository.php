<?php

namespace App\core\repositories;

use App\core\contracts\BaseContract;
use App\core\exception\CommonException;

abstract class BaseRepository implements BaseContract
{
    public function save(array $data): mixed
    {
        try {
            return $this->model->save($data);
        } catch (CommonException $e) {
            throw $e->dump();
        }
    }

    public function update(array $data, int $id): mixed
    {
        try {
            return $this->model->update($data, $id);
        } catch (CommonException $e) {
            throw $e->dump();
        }
    }

    public function all($columns = array('*'), string $orderBy = 'id', string $sortBy = 'desc'): mixed
    {
        try {
            return $this->model->get($columns, $orderBy, $sortBy);
        } catch (CommonException $e) {
            throw $e->dump();
        }
    }

    public function find(int $id): mixed
    {
        try {
            return $this->model->findOne($id);
        } catch (CommonException $e) {
            throw $e->dump();
        }
    }

    public function findOneOrFail(int $id): mixed
    {
        try {
            return $this->model->findOrFail($id);
        } catch (CommonException $e) {
            throw $e->dump();
        }
    }

    public function findBy(array $data): mixed
    {
        try {
            return $this->model->all($data);
        } catch (CommonException $e) {
            throw $e->dump();
        }
    }

    public function delete(int $id): mixed
    {
        try {
            return $this->model->deleteById($id);
        } catch (CommonException $e) {
            throw $e->dump();
        }
    }
}
