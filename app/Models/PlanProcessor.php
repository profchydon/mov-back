<?php

namespace App\Models;

use App\Domains\Constant\Plan\PlanPriceConstant;
use App\Domains\Constant\Plan\PlanProcessorConstant;
use App\Domains\Enum\Plan\PlanProcessorNameEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanProcessor extends BaseModel
{

    protected $casts = [
        PlanProcessorConstant::PLAN_PROCESSOR_NAME => PlanProcessorNameEnum::class,
    ];

    public function planPrice()
    {
        return $this->belongsTo(PlanPrice::class, PlanProcessorConstant::PLAN_PRICE_ID);
    }
}
