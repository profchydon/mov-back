<?php

namespace App\Repositories;

use App\Repositories\Contracts\PermissionRepositoryInterface;
use Spatie\Permission\Models\Permission;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{
    public function model(): string
    {
        return Permission::class;
    }

    public function allGroupedBy() {

        return Permission::query()
                ->get()
                ->groupBy('category');

    }
}
