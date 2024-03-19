<?php

namespace App\Models;

use App\Domains\Constant\Plan\PlanPriceConstant;
use App\Domains\Constant\Plan\PlanProcessorConstant;
use App\Domains\Enum\Plan\BillingCycleEnum;
use App\Domains\Enum\Plan\PlanProcessorNameEnum;
use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class PlanPrice extends BaseModel
{
    use UsesUUID, SoftDeletes;

    protected $casts = [
        PlanPriceConstant::ID => 'string',
        PlanPriceConstant::BILLING_CYCLE => BillingCycleEnum::class,
    ];

    public static function booted()
    {
        parent::booted();
        static::creating(function(self $model){
            $slugString = "{$model->plan_slug} {$model->currency_code} {$model->billing_cylce}";
            $model->slug = Str::slug($slugString);
        });
    }

    public function plan(){
        return $this->belongsTo(Plan::class, 'plan_slug', 'slug');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_code', 'code');
    }

    public function processor()
    {
        return $this->hasMany(PlanProcessor::class, 'plan_price_slug','slug');
    }

    public function flutterwaveProcessor()
    {
        return $this->processor()->where(PlanProcessorConstant::PAYMENT_PROCESSOR_SLUG, 'flutterwave');
    }

    public function swipeProcessor()
    {
        return $this->processor()->where(PlanProcessorConstant::PAYMENT_PROCESSOR_SLUG, 'stripe');
    }
}
