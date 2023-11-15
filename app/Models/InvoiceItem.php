<?php

namespace App\Models;

use App\Domains\Constant\InvoiceItemConstant;
use App\Domains\Enum\Invoice\InvoiceItemTypeEnum;
use App\Traits\GetsTableName;
use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class InvoiceItem extends BaseModel
{
    use SoftDeletes, UsesUUID;

    protected $guarded = [
        InvoiceItemConstant::ID,
    ];

    protected $casts = [
        InvoiceItemConstant::ID => 'string',
    ];

    public function item()
    {
        return $this->morphTo();
    }
}
