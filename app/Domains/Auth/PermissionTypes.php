<?php

namespace App\Domains\Auth;

enum PermissionTypes: string
{
    // Asset
    case ASSET_FULL_ACCESS = 'AssetFullAccess';
    case ASSET_CREATE_ACCESS = 'AssetCreateAccess';
    case ASSET_READ_ACCESS = 'AssetReadAccess';
    case ASSET_UPDATE_ACCESS = 'AssetUpdateAccess';
    case ASSET_DELETE_ACCESS = 'AssetDeleteAccess';
    case ASSET_TRANSFER_ACCESS = 'AssetTransferAccess';

    // Billing
    case BILLING_FULL_ACCESS = 'BillingFullAccess';
    case BILLING_CREATE_ACCESS = 'BillingCreateAccess';
    case BILLING_READ_ACCESS = 'BillingReadAccess';
    case BILLING_UPDATE_ACCESS = 'BillingUpdateAccess';
    case BILLING_DELETE_ACCESS = 'BillingDeleteAccess';

    // Account
    case ACCOUNT_FULL_ACCESS = 'AccountFullAccess';
    case ACCOUNT_READ_ACCESS = 'AccountReadAccess';
    case ACCOUNT_CREATE_ACCESS = 'AccountCreateAccess';
    case ACCOUNT_UPDATE_ACCESS = 'AccountUpdateAccess';
    case ACCOUNT_DELETE_ACCESS = 'AccountDeleteAccess';

    // Role
    case ROLE_FULL_ACCESS = 'RoleFullAccess';
    case ROLE_CREATE_ACCESS = 'RoleCreateAccess';
    case ROLE_READ_ACCESS = 'RoleReadAccess';
    case ROLE_DELETE_ACCESS = 'RoleDeleteAccess';
    case ROLE_UPDATE_ACCESS = 'RoleUpdateAccess';
}
