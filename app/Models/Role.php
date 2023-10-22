<?php

namespace App\Models;

use App\Domains\Constant\UserRoleConstant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\GetsTableName;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory, GetsTableName;

    public $guarded = [
        'id'
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
