<?php

namespace App\Domains\Constant;

use App\Domains\Enum\Tag\TagStatusEnum;

class TagConstant
{
    public const ID = 'id';
    public const TENANT_ID = 'tenant_id';
    public const COMPANY_ID = 'company_id';
    public const NAME = 'name';
    public const STATUS = 'status';

    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    public const DELETED_AT = 'deleted_at';


    public const STATUS_ENUM = [
        TagStatusEnum::ACTIVE,
        TagStatusEnum::INACTIVE,
    ];
}
