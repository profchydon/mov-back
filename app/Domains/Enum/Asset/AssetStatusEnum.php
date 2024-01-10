<?php

namespace App\Domains\Enum\Asset;

use App\Traits\ListsEnumValues;

enum AssetStatusEnum: string
{
    use ListsEnumValues;

    case PENDING_APPROVAL = 'Pending Approval';
    case AVAILABLE = 'Available';
    case CHECKED_OUT = 'Checked Out';
    case TRANSFERRED = 'Transferred';
    case ARCHIVED = 'Archived';
    case STOLEN = 'Stolen';
    case UNDER_MAINTENANCE = 'Under Maintenance';
    case DAMAGED = 'Damaged';
    case RETIRED = 'Retired';
}
