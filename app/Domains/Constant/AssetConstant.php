<?php

namespace App\Domains\Constant;

use App\Domains\Enum\Asset\AssetAquisitionTypeEnum;
use App\Domains\Enum\Asset\AssetStatusEnum;

/**
 * Class AssetConstant.
 */
class AssetConstant
{
    public const asset = 'asset';
    public const ID = 'id';
    public const ASSET_ID = 'asset_id';
    public const TENANT_ID = 'tenant_id';
    public const COMPANY_ID = 'company_id';
    public const NAME = 'name';
    public const MAKE = 'make';
    public const MODEL = 'model';
    public const SERIAL_NUMBER = 'serial_number';
    public const TYPE = 'type';
    public const TYPE_ID = 'type_id';
    public const PURCHASE_PRICE = 'purchase_price';
    public const PURCHASE_DATE = 'purchase_date';
    public const OFFICE_ID = 'office_id';
    public const OFFICE_AREA_ID = 'office_area_id';
    public const ASSIGNED_TO = 'assigned_to';
    public const ASSIGNED_DATE = 'assigned_date';
    public const ADDED_AT = 'added_at';
    public const STATUS = 'status';
    public const CURRENCY = 'currency';
    public const MAINTENANCE_CYCLE = 'maintenance_cycle';
    public const NEXT_MAINTENANCE_DATE = 'next_maintenance_date';
    public const IS_INSURED = 'is_insured';
    public const ACQUISITION_TYPE = 'acquisition_type';
    public const VENDOR_ID = 'vendor_id';
    public const CONDITION = 'condition';

    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    public const DELETED_AT = 'deleted_at';
    public const REMEMBER_TOKEN = 'remember_token';


    public const STATUS_ENUM = [
        AssetStatusEnum::ARCHIVED,
        AssetStatusEnum::CHECKED_OUT,
        AssetStatusEnum::TRANSFERRED,
    ];

    public const ACQUISITION_TYPE_ENUM = [
        AssetAquisitionTypeEnum::BRAND_NEW,
        AssetAquisitionTypeEnum::REFURBISHED,
        AssetAquisitionTypeEnum::USED,
    ];
}
