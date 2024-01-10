<?php

namespace App\Domains\Constant;

use App\Domains\Enum\User\UserStageEnum;
use App\Domains\Enum\User\UserStatusEnum;

/**
 * Class UserConstant.
 */
class UserRoleConstant
{
    public const USER = 'user';
    public const ID = 'id';
    public const USER_ID = 'user_id';
    public const TENANT_ID = 'tenant_id';
    public const COMPANY_ID = 'company_id';
    public const ROLE_ID = 'role_id';
    public const OFFICE_ID = 'office_id';
    public const STATUS = 'status';

    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    public const DELETED_AT = 'deleted_at';


    public const STATUS_ENUM = [
        UserStatusEnum::ACTIVE,
        UserStatusEnum::INACTIVE,
        UserStatusEnum::DEACTIVATED,
    ];

    public const STAGE_ENUM = [
        UserStageEnum::VERIFICATION,
        UserStageEnum::COMPANY_DETAILS,
        UserStageEnum::SUBSCRIPTION_PLAN,
        UserStageEnum::USERS,
        UserStageEnum::COMPLETED,
    ];
}
