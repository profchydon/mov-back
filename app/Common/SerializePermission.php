<?php

namespace App\Common;

class SerializePermission
{
    /**
     * SerializePermission constructor.
     * @param object[] $roles
     */
    public function __construct(private readonly object $roles)
    {
    }

    public function getRoles(): array
    {
        $roles = [];

        foreach ($this->roles as $role) {
            array_push($roles, $role);
        }

        return $roles;
    }

    public function stringifyPermission(): string
    {
        $permissions = '';

        foreach ($this->roles as $role) {
            foreach ($role->permissions as $permission) {
                $permissions .= !str_contains($permissions, $permission->name) ? $permission->name . ',' : null;
            }
        }

        return rtrim($permissions, ',');
    }
}
