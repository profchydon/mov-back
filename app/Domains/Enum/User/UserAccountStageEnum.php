<?php

namespace App\Domains\Enum\User;

use App\Traits\ListsEnumValues;

enum UserAccountStageEnum: string
{
    use ListsEnumValues;

    case VERIFICATION = 'VERIFICATION';
    case COMPANY_DETAILS = 'COMPANY DETAILS';
    case SUBSCRIPTION_PLAN = 'SUBSCRIPTION PLAN';
    case ADD_USERS = 'ADD USERS';
    case COMPLETED = 'COMPLETED';
}
