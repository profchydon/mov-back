<?php

namespace App\Domains\Enum\Subscription;

use App\Traits\ListsEnumValues;

enum SubscriptionAddOnStatusEnum: string
{
    use ListsEnumValues;

    case ACTIVE = 'Active';
    case INACTIVE = 'Inactive';
    case EXPIRED = 'Expired';
}
