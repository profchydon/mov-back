<?php

namespace App\Domains\Constant;

use App\Domains\Enum\Asset\AssetMakeStatusEnum;

class AssetMakeConstant
{
    public const ID = 'id';
    public const TENANT_ID = 'tenant_id';
    public const COMPANY_ID = 'company_id';
    public const NAME = 'name';
    public const STATUS = 'status';

    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';


    public const STATUS_ENUM = [
        AssetMakeStatusEnum::ACTIVE,
        AssetMakeStatusEnum::INACTIVE,
    ];
}
