<?php

namespace App\Domains\Enum\EventTrack;

use App\Traits\ListsEnumValues;

enum EventTrackEnum: string
{
    use ListsEnumValues;

    case USER_CREATED = 'User Created';
    case COMPANY_CREATED = 'Company Created';
    case ASSET_CREATED = 'Asset Created';
    case SUBSCRIPTION_ACTIVATED = 'Subscription Activated';
    case ASSET_CHECKED_OUT = 'Asset Checked Out';
}
