<?php

namespace App\Models;

use App\Domains\Constant\FileConstant;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class File extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [
        FileConstant::ID,
    ];

    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }
}
