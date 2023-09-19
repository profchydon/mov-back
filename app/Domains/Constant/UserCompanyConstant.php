<?php

namespace App\Domains\Constant;

use App\Domains\Enum\User\UserCompanyStatusEnum;

/**
 * Class UserConstant.
 */
class UserCompanyConstant
{
    public const ID = 'id';
    public const TENANT_ID = 'tenant_id';
    public const COMPANY_ID = 'company_id';
    public const USER_ID = 'user_id';
    public const STATUS = 'status';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    public const DELETED_AT = 'deleted_at';

    public const STATUS_ENUM = [
        UserCompanyStatusEnum::ACTIVE,
        UserCompanyStatusEnum::INACTIVE,
    ];
}
