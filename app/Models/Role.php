<?php

namespace App\Models;

use App\Traits\GetsTableName;
use App\Traits\QueryFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends \Spatie\Permission\Models\Role
{
    use HasFactory, GetsTableName, QueryFormatter;

    public $guarded = [
        'id',
    ];

    protected static array $searchable = [
        'name'
    ];

    public static $returnable = ['id', 'name'];


    // public function permissions(): HasMany
    // {
    //     return $this->hasMany(Permission::class);
    // }

    public function rolePermissions()
    {
        return $this->hasMany(RoleHasPermission::class, 'role_id');
    }

    public function permissions()
    {
        return $this->hasManyThrough(Permission::class, RoleHasPermission::class, 'role_id', 'id', 'id', 'permission_id');
    }
}
