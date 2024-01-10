<?php

namespace App\Domains\Constant;

use App\Domains\Enum\Subscription\SubscriptionAddOnStatusEnum;

/**
 * Class SubscriptionAddOnConstant.
 */
class SubscriptionAddOnConstant
{
    public const ID = 'id';
    public const TENANT_ID = 'tenant_id';
    public const COMPANY_ID = 'company_id';
    public const SUBSCRIPTION_ID = 'subscription_id';
    public const FEATURE_ID = 'feature_id';
    public const START_DATE = 'start_date';
    public const END_DATE = 'end_date';
    public const STATUS = 'status';

    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    public const DELETED_AT = 'deleted_at';


    public const STATUS_ENUM = [
        SubscriptionAddOnStatusEnum::ACTIVE,
        SubscriptionAddOnStatusEnum::INACTIVE,
    ];
}
