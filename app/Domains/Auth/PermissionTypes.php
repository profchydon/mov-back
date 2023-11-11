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

    // Office
    case OFFICE_FULL_ACCESS = 'OfficeFullAccess';
    case OFFICE_CREATE_ACCESS = 'OfficeCreateAccess';
    case OFFICE_READ_ACCESS = 'OfficeReadAccess';
    case OFFICE_DELETE_ACCESS = 'OfficeDeleteAccess';
    case OFFICE_UPDATE_ACCESS = 'OfficeUpdateAccess';

     // Audit
     case AUDIT_FULL_ACCESS = 'AuditFullAccess';
     case AUDIT_CREATE_ACCESS = 'AuditCreateAccess';
     case AUDIT_READ_ACCESS = 'AuditReadAccess';
     case AUDIT_DELETE_ACCESS = 'AuditDeleteAccess';
     case AUDIT_UPDATE_ACCESS = 'AuditUpdateAccess';

    // Vendor
    case VENDOR_FULL_ACCESS = 'VendorFullAccess';
    case VENDOR_CREATE_ACCESS = 'VendorCreateAccess';
    case VENDOR_READ_ACCESS = 'VendorReadAccess';
    case VENDOR_DELETE_ACCESS = 'VendorDeleteAccess';
    case VENDOR_UPDATE_ACCESS = 'VendorUpdateAccess';

    // Department
    case DEPARTMENT_FULL_ACCESS = 'DepartmentFullAccess';
    case DEPARTMENT_CREATE_ACCESS = 'DepartmentCreateAccess';
    case DEPARTMENT_READ_ACCESS = 'DepartmentReadAccess';
    case DEPARTMENT_DELETE_ACCESS = 'DepartmentDeleteAccess';
    case DEPARTMENT_UPDATE_ACCESS = 'DepartmentUpdateAccess';

    // Depreciation
    case DEPRECIATION_FULL_ACCESS = 'DepreciationFullAccess';
    case DEPRECIATION_CREATE_ACCESS = 'DepreciationCreateAccess';
    case DEPRECIATION_READ_ACCESS = 'DepreciationReadAccess';
    case DEPRECIATION_DELETE_ACCESS = 'DepreciationDeleteAccess';
    case DEPRECIATION_UPDATE_ACCESS = 'DepreciationUpdateAccess';

     // Docuemnt
     case DOCUMENT_FULL_ACCESS = 'DocumentFullAccess';
     case DOCUMENT_CREATE_ACCESS = 'DocumentCreateAccess';
     case DOCUMENT_READ_ACCESS = 'DocumentReadAccess';
     case DOCUMENT_DELETE_ACCESS = 'DocumentDeleteAccess';
     case DOCUMENT_UPDATE_ACCESS = 'DocumentUpdateAccess';
}


