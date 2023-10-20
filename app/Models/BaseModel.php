<?php

namespace App\Models;

use App\Traits\GetsTableName;
use App\Traits\QueryFormatter;
use App\Traits\WithActivityLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use GetsTableName, WithActivityLog, HasFactory, QueryFormatter;

    protected $guarded = [
        'id',
    ];
}
