<?php

namespace App\Models;

use App\Traits\GetsTableName;
use App\Traits\QueryFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends \Spatie\Permission\Models\Permission
{
    use HasFactory, GetsTableName, QueryFormatter;

    protected static array $searchable = [
        'name', 'display', 'category'
    ];

    protected static array $fiterable = [
        'name' => 'permissions.name',
        'category' => 'permissions.category'
    ];

}
