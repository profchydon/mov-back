<?php

namespace App\Models;

use App\Domains\Constant\TagConstant;
use App\Traits\GetsTableName;
use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taggable extends Model
{
    use HasFactory, GetsTableName, UsesUUID;

    protected $guarded = [
        TagConstant::ID,
    ];


    protected $hidden = [

    ];

    public function owner()
    {
        return $this->morphTo();
    }
}
