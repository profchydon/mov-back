<?php

namespace App\Domains\Constant;

use App\Domains\Enum\Asset\AssetTypeEnum;

/**
 * Class AssetTypeConstant.
 */
class AssetTypeConstant
{

    public const ID = 'id';
    public const NAME = 'name';
    public const STATUS = 'status';

    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';


    public const STATUS_ENUM = [
        AssetTypeEnum::ACTIVE,
        AssetTypeEnum::INACTIVE,
    ];

}
