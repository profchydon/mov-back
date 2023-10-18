<?php

namespace App\Domains\Constant;

use App\Domains\Enum\VendorStatusEnum;

class VendorConstant
{
    public const ID = 'id';
    public const TENANT_ID = 'tenant_id';
    public const COMPANY_ID = 'company_id';
    public const NAME = 'name';
    public const EMAIL = 'email';
    public const PHONE = 'phone';
    public const ADDRESS = 'address';
    public const STATUS = 'status';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    public const STATUS_ENUM = [
        VendorStatusEnum::ACTIVE,
        VendorStatusEnum::INACTIVE,
    ];
}
