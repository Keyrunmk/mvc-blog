<?php

namespace App\core\repositories;

use App\core\contracts\AdminContract;
use App\models\Admin;
use Exception;
use Throwable;

class AdminRepository extends BaseRepository implements AdminContract
{
    protected Admin $model;

    public function __construct()
    {
        $this->model = new Admin();
    }

    public function listAdmins(array $columns = ["*"], string $order = "id", string $sort = "desc"): mixed
    {
        try {
            return $this->all($columns, $order, $sort);
        } catch (Exception | Throwable $e) {
            throw $e;
        }
    }

    public function findAdminById(int $id): mixed
    {
        try {
            $result = $this->findOneOrFail($id);
            return $result;
        } catch (Exception | Throwable $e) {
            throw $e;
        }
    }

    public function createAdmin(array $params): int
    {
        try {
            return $this->save($params);
        } catch (Exception | Throwable $e) {
            throw $e;
        }
    }

    public function addAdminRole(int $adminId, int $roleId): bool
    {
        try {
            $data = [
                "admin_id" => $adminId,
                "role_id" => $roleId,
            ];
            return $this->saveByTableName($data, "admins_roles");
        } catch (Exception | Throwable $e) {
            throw $e;
        }
    }

    public function updateAdmin(array $params, int $id): mixed
    {
        try {
            return $this->update($params, $id);
        } catch (Exception | Throwable $e) {
            throw $e;
        }
    }

    public function deleteAdmin(int $id): mixed
    {
        try {
            $this->delete($id);
        } catch (Exception | Throwable $e) {
            throw $e;
        }
    }
}
