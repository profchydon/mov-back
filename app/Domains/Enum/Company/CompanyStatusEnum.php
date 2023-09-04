<?php

namespace App\Domains\Enum\Bid;

use App\Traits\ListsEnumValues;

enum CompanyStatusEnum: string
{
    use ListsEnumValues;

    case ACCEPTED = 'accepted';
    case WON = 'won';
    case FORFEITED = 'forfeited';
}
