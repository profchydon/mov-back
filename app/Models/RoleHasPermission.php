<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\GetsTableName;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoleHasPermission extends Model
{
    use HasFactory, GetsTableName;


    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class);
    }

}
