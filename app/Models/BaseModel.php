<?php

namespace App\Models;

use App\Traits\GetsTableName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use GetsTableName;

    protected $guarded = [
        'id'
    ];
}
