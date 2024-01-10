<?php

namespace App\Domains\Constant;

use App\Domains\Enum\Tenant\TenantStatusEnum;

/**
 * Class UserConstant.
 */
class TenantConstant
{
    public const ID = 'id';
    public const NAME = 'name';
    public const EMAIL = 'email';
    public const SUB_DOMAIN = 'sub_domain';
    public const STATUS = 'status';

    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    public const DELETED_AT = 'deleted_at';


    public const STATUS_ENUM = [
        TenantStatusEnum::ACTIVE,
        TenantStatusEnum::INACTIVE,
    ];
}
