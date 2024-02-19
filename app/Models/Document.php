<?php

namespace App\Models;

use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\UploadedFile;
use Spatie\Activitylog\Traits\LogsActivity;

class Document extends BaseModel
{
    use UsesUUID, LogsActivity, SoftDeletes;

    protected static array $searchable = [
        'name', 'type'
    ];

    protected static array $filterable = [
        'type' => 'company_documents.type',
    ];

    public function generateFileName(string $ext)
    {
        return sprintf('%s/%s/%s.%s', "company_documents", $this->company_id, $this->id, $ext);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function file()
    {
        return $this->morphOne(File::class, 'fileable');
    }
}
