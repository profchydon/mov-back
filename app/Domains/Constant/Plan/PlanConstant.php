<?php

namespace App\Domains\Constant\Plan;

use App\Domains\Enum\Plan\PlanStatusEnum;

/**
 * Class PlanConstant.
 */
class PlanConstant
{
    public const ID = 'id';
    public const NAME = 'name';
    public const DESCRIPTION = 'description';
    public const PRECEDING_PLAN_NAME = 'preceding_plan_name';
    public const STATUS = 'status';
    public const OFFERS = 'offers';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    public const DELETED_AT = 'deleted_at';


    public const STATUS_ENUM = [
        PlanStatusEnum::ACTIVE,
        PlanStatusEnum::INACTIVE,
    ];
}
