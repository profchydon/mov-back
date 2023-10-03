<?php

namespace App\Repositories;

use App\Repositories\Contracts\RoleRepositoryInterface;
use Spatie\Permission\Models\Role;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    public function model(): string
    {
        return Role::class;
    }
}
