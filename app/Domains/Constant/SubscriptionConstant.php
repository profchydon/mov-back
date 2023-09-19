<?php

namespace App\Domains\Constant;
use App\Domains\Enum\Plan\BillingCycleEnum;
use App\Domains\Enum\Subscription\SubscriptionStatusEnum;

/**
 * Class SubscriptionConstant.
 */
class SubscriptionConstant
{
    public const ID = 'id';
    public const TENANT_ID = 'tenant_id';
    public const COMPANY_ID = 'company_id';
    public const PLAN_ID = 'plan_id';
    public const INVOICE_ID = 'invoice_id';
    public const START_DATE = 'start_date';
    public const END_DATE = 'end_date';
    public const BILLING_CYCLE = 'billing_cycle';
    public const STATUS = 'status';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    public const DELETED_AT = 'deleted_at';


    public const STATUS_ENUM = [
        SubscriptionStatusEnum::ACTIVE,
        SubscriptionStatusEnum::INACTIVE,
        SubscriptionStatusEnum::EXPIRED,
    ];

    public const BILLING_CYCLE_ENUM = [
        BillingCycleEnum::MONTHLY,
        BillingCycleEnum::YEARLY,
    ];
}
