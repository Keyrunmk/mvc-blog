<?php

namespace App\core\repositories;

use App\core\contracts\BaseContract;
use App\core\exception\CommonException;
use Exception;

class BaseRepository implements BaseContract
{
    public function save(array $data): mixed
    {
        try {
            return $this->model->save($data);
        } catch (Exception $e) {
            $exception = new CommonException($e);
            throw $exception->dump();
        }
    }

    public function update(array $data, int $id): mixed
    {
        try {
            return $this->model->update($data, $id);
        } catch (Exception $e) {
            $exception = new CommonException($e);
            throw $exception->dump();
        }
    }

    public function all($columns = array('*'), string $orderBy = 'id', string $sortBy = 'desc'): mixed
    {
        try {
            return $this->model->get($columns, $orderBy, $sortBy);
        } catch (Exception $e) {
            $exception = new CommonException($e);
            throw $exception->dump();
        }
    }

    public function find(int $id): mixed
    {
        try {
            return $this->model->findOne($id);
        } catch (Exception $e) {
            $exception = new CommonException($e);
            throw $exception->dump();
        }
    }

    public function findOneOrFail(int $id): mixed
    {
        try {
            return $this->model->findOrFail($id);
        } catch (Exception $e) {
            $exception = new CommonException($e);
            throw $exception->dump();
        }
    }

    public function findBy(array $data): mixed
    {
        try {
            return $this->model->all($data);
        } catch (Exception $e) {
            $exception = new CommonException($e);
            throw $exception->dump();
        }
    }

    public function delete(int $id): mixed
    {
        try {
            return $this->model->delete($id);
        } catch (Exception $e) {
            $exception = new CommonException($e);
            throw $exception->dump();
        }
    }
}
