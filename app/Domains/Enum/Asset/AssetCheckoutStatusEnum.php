<?php

namespace App\Domains\Enum\Asset;

use App\Traits\ListsEnumValues;

enum AssetCheckoutStatusEnum : string
{
  use ListsEnumValues;

  case CHECKED_OUT = 'checked_out';
  case OVERDUE = 'overdue';
  case RETURNED = 'returned';
}
