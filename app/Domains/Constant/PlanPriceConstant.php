<?php

namespace App\Domains\Constant;

use App\Domains\Enum\Plan\BillingCycleEnum;

/**
 * Class PlanPriceConstant.
 */
class PlanPriceConstant
{
    public const ID = 'id';
    public const PLAN_ID = 'plan_id';
    public const CURRENCY_CODE = 'currency_code';
    public const AMOUNT = 'amount';
    public const BILLING_CYCLE = 'billing_cycle';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    public const DELETED_AT = 'deleted_at';

    public const BILLING_CYCLE_ENUM = [
        BillingCycleEnum::MONTHLY,
        BillingCycleEnum::YEARLY,
    ];
}
