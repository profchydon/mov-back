<?php

namespace App\Domains\Constant;

use App\Domains\Enum\Office\OfficeStatusEnum;

class OfficeConstant
{
    public const ID = 'id';
    public const TENANT_ID = 'tenant_id';
    public const COMPANY_ID = 'company_id';
    public const NAME = 'name';
    public const ADDRESS = 'street_address';
    public const CURRENCY_ID = 'currency_id';
    public const CURRENCY_CODE = 'currency_code';
    public const COUNTRY = 'country';
    public const STATE = 'state';
    public const LATITUDE = 'latitude';
    public const LONGITUDE = 'longitude';
    public const STATUS = 'status';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    public const DELETED_AT = 'deleted_at';
    public const OFFICE_ID = 'office_id';


    public const OFFICE_STATUS_ENUM = [
        OfficeStatusEnum::ACTIVE,
        OfficeStatusEnum::INACTIVE,
    ];
}
