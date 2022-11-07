<?php

namespace App\core\middlewares;

use App\core\Model;
use Exception;

class RoleMiddleware extends BaseMiddleware
{
    public function __construct(?Model $model, array $roles, array $permissions = null)
    {
        $this->model = $model;
        $this->roles = $roles;
        $this->permissions = $permissions;
    }

    public function execute()
    {
        if (!$this->model->hasRole($this->roles)) {
            if ($this->permissions !== null && !$this->model->hasPermission($this->permissions)) {
                throw new Exception("You don't have the permission");
            }
            throw new Exception("You don't have the role");
        }
    }
}