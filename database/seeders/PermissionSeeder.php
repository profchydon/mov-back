<?php

namespace Database\Seeders;

use App\Domains\Auth\PermissionTypes;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = collect([

            ['name' => PermissionTypes::ASSET_FULL_ACCESS, 'display' => 'Full Access to Assets', 'category' => 'Asset Management'],
            ['name' => PermissionTypes::ASSET_CREATE_ACCESS, 'display' => 'Permission to Create Asset', 'category' => 'Asset Management'],
            ['name' => PermissionTypes::ASSET_READ_ACCESS, 'display' => 'Permission to View Asset', 'category' => 'Asset Management'],
            ['name' => PermissionTypes::ASSET_UPDATE_ACCESS, 'display' => 'Permission to Update Asset', 'category' => 'Asset Management'],
            ['name' => PermissionTypes::ASSET_TRANSFER_ACCESS, 'display' => 'Permission to Transfer Asset', 'category' => 'Asset Management'],

            ['name' => PermissionTypes::BILLING_FULL_ACCESS, 'display' => 'Full Access to Billing', 'category' => 'Billing Management'],
            ['name' => PermissionTypes::BILLING_CREATE_ACCESS, 'display' => 'Permission to Create Billing', 'category' => 'Billing Management'],
            ['name' => PermissionTypes::BILLING_UPDATE_ACCESS, 'display' => 'Permission to Update Billing', 'category' => 'Billing Management'],
            ['name' => PermissionTypes::BILLING_READ_ACCESS, 'display' => 'Permission to View Billing', 'category' => 'Billing Management'],

            ['name' => PermissionTypes::ACCOUNT_FULL_ACCESS, 'display' => 'Full Access to Users', 'category' => 'User Management'],
            ['name' => PermissionTypes::ACCOUNT_CREATE_ACCESS, 'display' => 'Permission to Create Users', 'category' => 'User Management'],
            ['name' => PermissionTypes::ACCOUNT_READ_ACCESS, 'display' => 'Permission to View Users', 'category' => 'User Management'],
            ['name' => PermissionTypes::ACCOUNT_UPDATE_ACCESS, 'display' => 'Permission to Update Users', 'category' => 'User Management'],
            ['name' => PermissionTypes::ACCOUNT_DELETE_ACCESS, 'display' => 'Permission to Delete Users', 'category' => 'User Management'],

            ['name' => PermissionTypes::ROLE_FULL_ACCESS, 'display' => 'Full Access to Roles', 'category' => 'Role and Permission Management'],
            ['name' => PermissionTypes::ROLE_CREATE_ACCESS, 'display' => 'Permission to Create Roles', 'category' => 'Role and Permission Management'],
            ['name' => PermissionTypes::ROLE_READ_ACCESS, 'display' => 'Permission to View Roles', 'category' => 'Role and Permission Management'],
            ['name' => PermissionTypes::ROLE_UPDATE_ACCESS, 'display' => 'Permission to Update Roles', 'category' => 'Role and Permission Management'],
            ['name' => PermissionTypes::ROLE_DELETE_ACCESS, 'display' => 'Permission to Delete Roles', 'category' => 'Role and Permission Management'],

            ['name' => PermissionTypes::OFFICE_FULL_ACCESS, 'display' => 'Full Access to Offices', 'category' => 'Office Management'],
            ['name' => PermissionTypes::OFFICE_CREATE_ACCESS, 'display' => 'Permission to Create Offices', 'category' => 'Office Management'],
            ['name' => PermissionTypes::OFFICE_READ_ACCESS, 'display' => 'Permission to View Offices', 'category' => 'Office Management'],
            ['name' => PermissionTypes::OFFICE_UPDATE_ACCESS, 'display' => 'Permission to Update Offices', 'category' => 'Office Management'],
            ['name' => PermissionTypes::OFFICE_DELETE_ACCESS, 'display' => 'Permission to Delete Offices', 'category' => 'Office Management'],

            ['name' => PermissionTypes::AUDIT_FULL_ACCESS, 'display' => 'Full Access to Audit & Reports', 'category' => 'Audit & Report Management'],
            ['name' => PermissionTypes::AUDIT_CREATE_ACCESS, 'display' => 'Permission to Create Audit & Reports', 'category' => 'Audit & Report Management'],
            ['name' => PermissionTypes::AUDIT_READ_ACCESS, 'display' => 'Permission to View Audit & Reports', 'category' => 'Audit & Report Management'],
            ['name' => PermissionTypes::AUDIT_DELETE_ACCESS, 'display' => 'Permission to Delete Audit & Reports', 'category' => 'Audit & Report Management'],

            ['name' => PermissionTypes::VENDOR_FULL_ACCESS, 'display' => 'Full Access to Vendors', 'category' => 'Vendor Management'],
            ['name' => PermissionTypes::VENDOR_CREATE_ACCESS, 'display' => 'Permission to Create Vendors', 'category' => 'Vendor Management'],
            ['name' => PermissionTypes::VENDOR_READ_ACCESS, 'display' => 'Permission to View Vendors', 'category' => 'Vendor Management'],
            ['name' => PermissionTypes::VENDOR_UPDATE_ACCESS, 'display' => 'Permission to Update Vendors', 'category' => 'Vendor Management'],
            ['name' => PermissionTypes::VENDOR_DELETE_ACCESS, 'display' => 'Permission to Delete Vendors', 'category' => 'Vendor Management'],

            ['name' => PermissionTypes::DEPARTMENT_FULL_ACCESS, 'display' => 'Full Access to Department & Teams', 'category' => 'Department Management'],
            ['name' => PermissionTypes::DEPARTMENT_CREATE_ACCESS, 'display' => 'Permission to Create Department & Teams', 'category' => 'Department Management'],
            ['name' => PermissionTypes::DEPARTMENT_READ_ACCESS, 'display' => 'Permission to View Department & Teams', 'category' => 'Department Management'],
            ['name' => PermissionTypes::DEPARTMENT_UPDATE_ACCESS, 'display' => 'Permission to Update Department & Teams', 'category' => 'Department Management'],
            ['name' => PermissionTypes::DEPARTMENT_DELETE_ACCESS, 'display' => 'Permission to Delete Department & Teams', 'category' => 'Department Management'],

            ['name' => PermissionTypes::DOCUMENT_FULL_ACCESS, 'display' => 'Full Access to Documents', 'category' => 'Document Management'],
            ['name' => PermissionTypes::DOCUMENT_CREATE_ACCESS, 'display' => 'Permission to Create Documents', 'category' => 'Document Management'],
            ['name' => PermissionTypes::DOCUMENT_READ_ACCESS, 'display' => 'Permission to View Documents', 'category' => 'Document Management'],
            ['name' => PermissionTypes::DOCUMENT_UPDATE_ACCESS, 'display' => 'Permission to Update Documents', 'category' => 'Document Management'],
            ['name' => PermissionTypes::DOCUMENT_DELETE_ACCESS, 'display' => 'Permission to Delete Documents', 'category' => 'Document Management'],
        ]);

        $permissions->each(function ($permission) {
            Permission::firstOrCreate([
                'name' => $permission['name']->value,
                'display' => $permission['display'],
                'category' => $permission['category'],
            ]);
        });
    }
}
