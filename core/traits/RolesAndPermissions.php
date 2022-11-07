<?php

namespace App\core\traits;

use App\models\Permission;
use App\models\Role;

trait RolesAndPermissions
{
    public Permission $permission;
    public Role $role;

    public function __construct()
    {
        $this->permission = new Permission();
        $this->role = new Role();
    }

    public function roles(): array
    {
        $roles = [];
        foreach ($this->findManyToManyById("role", "admin", $this->tableName() . "_roles", $this->id, "slug") as $key => $role) {
            $roles[] = $role["slug"];
        }
        return $roles;
    }

    public function permissions(): array
    {
        $permissions = [];
        foreach ($this->findManyToManyById("permission", "role", "roles_permissions", $this->id, "slug") as $key => $permission) {
            $permissions[] = $permission["slug"];
        }
        return $permissions;
    }

    public function hasRole(string|array $roles): bool
    {
        foreach ($roles as $role) {
            if (in_array($role, $this->roles())) {
                return true;
            }
        }
        return false;
    }

    // public function hasPermission(string|array $permissions): bool
    // {
    //     foreach ($permissions as $permission) {
    //         if (in_array($permission, $this->permissions())) {
    //             return true;
    //         }
    //     }
    //     return false;
    // }

    // public function hasPermissionTo($permission): bool
    // {
    //     return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
    // }

    // public function hasPermissionThroughRole($permission): bool
    // {
    //     foreach ($permission->roles as $role) {
    //         if (in_array($role, $this->roles())) {
    //             return true;
    //         }
    //     }
    //     return false;
    // }

    public function getAllRoles(array $column=["*"])
    {
        return $this->role->get($column);
    }

    public function getAllPermissions(array $permissions): array
    {
        return $this->permission->findAll($permissions);
    }

    // public function givePermissionTo(...$permissions)
    // {
    //     $permissions = $this->getAllPermissions($permissions);
    //     if ($permissions === null) {
    //         return $this;
    //     }
    //     $this->permission->save($permissions);
    //     return $this;
    // }

    // public function deletePermissions(...$permissions)
    // {
    //     $permissions = $this->getAllPermissions($permissions);
    //     if (in_array($permissions, $this->permissions())) {
    //         $this->permission->delete($permissions);
    //     }
    // }
}
