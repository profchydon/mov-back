<?php

namespace App\Models;

use App\Traits\GetsTableName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory, GetsTableName;

    protected $casts = [
      'states' => 'json',
    ];

    public static function boot()
    {
        parent::boot();
    }
}
