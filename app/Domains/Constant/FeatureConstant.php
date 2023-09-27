<?php

namespace App\Domains\Constant;

use App\Domains\Enum\Feature\FeaturePriceEnum;
use App\Domains\Enum\Feature\FeatureStatusEnum;

/**
 * Class UserConstant.
 */
class FeatureConstant
{
    public const ID = 'id';
    public const NAME = 'name';
    public const PRICING = 'pricing';
    public const STATUS = 'status';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    public const DELETED_AT = 'deleted_at';


    public const STATUS_ENUM = [
        FeatureStatusEnum::ACTIVE,
        FeatureStatusEnum::INACTIVE,
    ];
    public const FEATURE_PRICING_ENUM = [
        FeaturePriceEnum::FREE,
        FeaturePriceEnum::PAID,
    ];
}
