<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\GetsTableName;

class Tag extends Model
{
    use HasFactory, GetsTableName;
}
