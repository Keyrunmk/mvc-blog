<?php

namespace App\core\repositories;

use App\core\contracts\BaseContract;
use Exception;
use Throwable;

abstract class BaseRepository implements BaseContract
{
    public function save(array $data): mixed
    {
        try {
            return $this->model->save($data);
        } catch (Exception | Throwable $e) {
            throw $e;
        }
    }

    public function update(array $data, int $id): mixed
    {
        try {
            return $this->model->update($data, $id);
        } catch (Exception | Throwable $e) {
            throw $e;
        }
    }

    public function all($columns = array('*'), string $orderBy = 'id', string $sortBy = 'desc'): mixed
    {
        try {
            return $this->model->get($columns, $orderBy, $sortBy);
        } catch (Exception | Throwable $e) {
            throw $e;
            // Response::setStatusCode((int) $e->getCode());
            // var_dump($e->getMessage());
        }
    }

    public function find(int $id): mixed
    {
        try {
            return $this->model->findOne($id);
        } catch (Exception | Throwable $e) {
            throw $e;
        }
    }

    public function findOneOrFail(int $id): mixed
    {
        try {
            return $this->model->findOrFail($id);
        } catch (Exception | Throwable $e) {
            throw $e;
        }
    }

    public function findBy(array $data): mixed
    {
        try {
            return $this->model->all($data);
        } catch (Exception | Throwable $e) {
            throw $e;
        }
    }

    public function delete(int $id): mixed
    {
        try {
            return $this->model->deleteById($id);
        } catch (Exception | Throwable $e) {
            throw $e;
        }
    }
}
