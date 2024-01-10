<?php

namespace App\Models;

use App\Domains\Constant\FileConstant;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory, HasUuids;

    protected $appends = ['link'];

    protected $guarded = [
        FileConstant::ID,
    ];

    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }

    protected function path(): Attribute
    {
       return Attribute::make(get: fn ($value) => $this->getTemporaryLink());
    }

    public function getLinkAttribute()
    {
        $cacheTime = now()->addHours(24);

        return Cache::remember("link-{$this->id}", $cacheTime, function () use ($cacheTime) {
            return Storage::disk('s3')->temporaryUrl($this->path, $cacheTime);
        });
    }

    private function getTemporaryLink()
    {
        $cacheTime = now()->addHours(24);

        return Cache::remember("link-{$this->id}", $cacheTime, function () use ($cacheTime) {
            return Storage::disk('s3')->temporaryUrl($this->path, $cacheTime);
        });
    }
}
