<?php

namespace App\Domains\Constant;

use App\Domains\Enum\User\UserAccountStageEnum;
use App\Domains\Enum\User\UserStatusEnum;

/**
 * Class UserConstant.
 */
class UserConstant
{
    public const USER = 'user';
    public const ID = 'id';
    public const USER_ID = 'user_id';
    public const TENANT_ID = 'tenant_id';
    public const FIRST_NAME = 'first_name';
    public const LAST_NAME = 'last_name';
    public const EMAIL = 'email';
    public const PASSWORD = 'password';
    public const PHONE_CODE = 'phone_code';
    public const PHONE = 'phone';
    public const COMPANY_ID = 'company_id';
    public const COUNTRY_ID = 'country_id';
    public const STATUS = 'status';
    public const STAGE = 'stage';
    public const LAST_LOGIN = 'last_login';
    public const EMAIL_VERIFIED_AT = 'email_verified_at';

    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    public const DELETED_AT = 'deleted_at';
    public const REMEMBER_TOKEN = 'remember_token';


    public const STATUS_ENUM = [
        UserStatusEnum::ACTIVE,
        UserStatusEnum::INACTIVE,
        UserStatusEnum::DEACTIVATED,
    ];

    public const STAGE_ENUM = [
        UserAccountStageEnum::VERIFICATION,
        UserAccountStageEnum::COMPANY_DETAILS,
        UserAccountStageEnum::SUBSCRIPTION_PLAN,
        UserAccountStageEnum::ADD_USERS,
        UserAccountStageEnum::COMPLETED
    ];
}
