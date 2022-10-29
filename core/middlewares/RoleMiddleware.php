<?php

namespace App\core\middlewares;

use App\core\exception\CommonException;
use App\core\Model;

class RoleMiddleware extends BaseMiddleware
{
    public function __construct(Model $model, array $roles, array $permissions = null)
    {
        $this->model = $model;
        $this->roles = $roles;
        $this->permissions = $permissions;
    }

    public function execute()
    {
        if (!$this->model->hasRole($this->roles)) {
            if ($this->permissions !== null && !$this->model->hasPermission($this->permissions)) {
                throw new CommonException("You don't have the permission");
            }
            throw new CommonException("You don't have the role");
        }
    }
}
