<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetDocument extends BaseModel
{
    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }

    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id');
    }
}
