<?php

namespace App\Domains\Auth;

enum PermissionTypes: string
{
    // Asset
    case ASSET_FULL_ACCESS = 'AssetFullAccess';
    case ASSET_CREATE_ACCESS = 'AssetCreateAccess';
    case ASSET_READ_ACCESS = 'AssetReadAccess';
    case ASSET_TRANSFER_ACCESS = 'AssetTransferAccess';

    // Billing
    case BILLING_FULL_ACCESS = 'BillingFullAccess';
    case BILLING_READ_ACCESS = 'BillingReadAccess';
    case BILLING_CREATE_ACCESS = 'BillingCreateAccess';

    // Account
    case ACCOUNT_FULL_ACCESS =  'AccountFullAccess';
    case ACCOUNT_READ_ACCESS = 'AccountReadAccess';
    case ACCOUNT_CREATE_ACCESS = 'AccountCreateAccess';
}
