<?php

namespace App\Domains\Constant;
use App\Domains\Enum\Currency\CurrencyStatusEnum;



class CurrencyConstant
{

    public const ID = 'id';
    public const NAME = 'name';
    public const CODE = 'CODE';
    public const SYMBOL = 'symbol';
    public const STATUS = 'status';
    public const CREATED_AT = 'created_at';

    public const STATUS_ENUM = [
        CurrencyStatusEnum::ACTIVE,
        CurrencyStatusEnum::INACTIVE,
    ];

}
