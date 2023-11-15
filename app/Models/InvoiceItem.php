<?php

namespace App\Models;

use App\Domains\Constant\InvoiceItemConstant;
use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\SoftDeletes;

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
