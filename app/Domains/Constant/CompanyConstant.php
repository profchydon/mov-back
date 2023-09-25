<?php

namespace App\Domains\Constant;

use App\Domains\Enum\Company\CompanyStatusEnum;

/**
 * Class UserConstant.
 */
class CompanyConstant
{
    public const ID = 'id';
    public const COMPANY_ID = 'company_id';
    public const TENANT_ID = 'tenant_id';
    public const NAME = 'name';
    public const EMAIL = 'email';
    public const SIZE = 'size';
    public const PHONE = 'phone';
    public const INDUSTRY = 'industry';
    public const ADDRESS = 'address';
    public const COUNTRY = 'country';
    public const STATE = 'state';
    public const SSO_ID = 'sso_id';
    public const STATUS = 'status';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    public const DELETED_AT = 'deleted_at';


    public const STATUS_ENUM = [
        CompanyStatusEnum::ACTIVE,
        CompanyStatusEnum::INACTIVE,
    ];
}
