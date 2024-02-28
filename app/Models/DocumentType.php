<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DocumentType extends BaseModel
{
    protected static array $searchable = [
        'name'
    ];

    protected function name(): Attribute
    {
        return Attribute::make(get: fn($v) => ucwords($v), set: fn($v) => Str::lower($v));
    }
}
