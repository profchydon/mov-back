<?php

namespace App\Models;

use App\Domains\Constant\Plan\PlanProcessorConstant;
use App\Domains\Enum\Plan\PlanProcessorNameEnum;

class PlanProcessor extends BaseModel
{
    public function planPrice()
    {
        return $this->belongsTo(PlanPrice::class, PlanProcessorConstant::PLAN_PRICE_ID);
//        return $this->belongsTo(PlanPrice::class, PlanProcessorConstant::PLAN_PRICE_SLUG, 'slug');
    }

    public function processor()
    {
        return $this->belongsTo(PaymentProcessor::class, PlanProcessorConstant::PAYMENT_PROCESSOR_SLUG, 'slug');
    }
}
