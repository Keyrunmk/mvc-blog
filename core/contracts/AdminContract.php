<?php

namespace App\core\contracts;

interface AdminContract
{
    public function listAdmins(array $columns = ["*"], string $order = "id", string $sort = "desc"): mixed;

    public function findAdminById(int $id): mixed;

    public function createAdmin(array $params): int;

    public function addAdminRole(int $adminId, int $roleId): bool;

    public function updateAdmin(array $params, int $id): mixed;

    public function deleteAdmin(int $id): mixed;
}