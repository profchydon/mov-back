<?php

namespace App\Domains\Constant;

use App\Domains\Enum\Plan\PlanStatusEnum;

/**
 * Class PlanConstant.
 */
class PlanConstant
{
    public const ID = 'id';
    public const NAME = 'name';
    public const TYPE = 'type';
    public const STATUS = 'status';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    public const DELETED_AT = 'deleted_at';


    public const STATUS_ENUM = [
        PlanStatusEnum::ACTIVE,
        PlanStatusEnum::INACTIVE,
    ];

}
