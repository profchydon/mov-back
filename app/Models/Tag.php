<?php

namespace App\Models;

use App\Traits\HasCompany;
use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Tag extends BaseModel
{
    use HasFactory, UsesUUID, HasCompany;

    protected static $searchable = [
        'name',
    ];

    protected static $filterable = [
        'name' => 'tags.name',
        'status' => 'tags.status',
        'company' => 'tags.company_id',
    ];

    public function assets()
    {
        return $this->hasMany(Asset::class, 'taggable_id')->where('taggable_type', Asset::class);
    }

    protected function name()
    {
        Attribute::make(get: fn($value) => Str::title($value), set: fn($value) => Str::lower($value));
    }
}
