<?php

namespace App\Models;

use App\Domains\Constant\Asset\AssetConstant;
use App\Domains\Enum\Asset\AssetStatusEnum;
use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\UploadedFile;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Document extends BaseModel
{
    use UsesUUID, SoftDeletes;

    protected static array $searchable = [
        'name', 'type'
    ];

    protected static array $filterable = [
        'type' => 'documents.type',
    ];

    public function generateFileName(string $ext)
    {
        return sprintf('%s/%s/%s.%s', "company_documents", $this->company_id, $this->id, $ext);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function file()
    {
        return $this->morphOne(File::class, 'fileable');
    }

    public function history()
    {
        return $this->hasMany(ActivityLog::class, 'subject_id')->latest();
    }

    public function assets()
    {
        return $this->belongsToMany(Asset::class, 'asset_documents', 'document_id', 'asset_id')->whereNotIn(AssetConstant::STATUS, [AssetStatusEnum::ARCHIVED->value]);
    }
}
