<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PaymentProcessor extends BaseModel
{
    protected static function booted()
    {
        parent::booted();
        parent::creating(function(self $model){
            $model->slug = Str::slug($model->name);
        });
    }
}
