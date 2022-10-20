<?php

namespace app\core\contracts;

interface BaseContract
{
    public function save(array $data): mixed;

    public function update(array $data, int $id): mixed;

    public function all($columns = array("*"), string $orderBy = "id", string $sortBy = "desc"): mixed;

    public function find(int $id): mixed;

    public function findOneOrFail(int $id): mixed;

    public function findBy(array $data): mixed;

    public function delete(int $id): mixed;
}