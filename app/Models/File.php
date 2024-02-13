<?php

namespace App\Models;

use App\Domains\Constant\FileConstant;
use Aws\S3\S3Client;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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

    protected function path(): Attribute
    {
        return Attribute::make(get: fn($value) => $this->getTemporaryLink($value));
    }

    public function getVersionsAttribute()
    {
        $s3 = new S3Client([
            'version' => 'latest',
            'region' => env('AWS_DEFAULT_REGION'),
            'credentials' => [
                'key'    => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        $versions = $s3->listObjectVersions([
            'Bucket' => env('AWS_BUCKET'),
            'Prefix' => $this->attributes['path'],
        ]);

        return collect($versions->get('Versions'))->map(fn($version) => [$version["Key"] => Storage::disk('s3')->temporaryUrl($this->attributes['path'], now()->addMinutes(60), [
            'VersionId' => $version["VersionId"],
        ])]);
    }

    private function getTemporaryLink($path)
    {
        $cacheTime = now()->addHours(24);

        return Cache::remember("link-{$this->id}", $cacheTime, function () use ($cacheTime, $path) {
            return Storage::disk('s3')->temporaryUrl($path, $cacheTime);
        });
    }
}
