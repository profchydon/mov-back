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
            ['name' => PermissionTypes::ASSET_FULL_ACCESS, 'display' => 'Full Access to Assets'],
            ['name' => PermissionTypes::ASSET_CREATE_ACCESS, 'display' => 'Permission to Create Asset'],
            ['name' => PermissionTypes::ASSET_READ_ACCESS, 'display' => 'Permission to View Asset'],
            ['name' => PermissionTypes::ASSET_TRANSFER_ACCESS, 'display' => 'Permission to Transfer Asset'],

            ['name' => PermissionTypes::BILLING_FULL_ACCESS, 'display' => 'Full Access to Billing'],
            ['name' => PermissionTypes::BILLING_CREATE_ACCESS, 'display' => 'Permission to Create Billing'],
            ['name' => PermissionTypes::BILLING_READ_ACCESS, 'display' => 'Permission to View Billing'],

            ['name' => PermissionTypes::ACCOUNT_FULL_ACCESS, 'display' => 'Full Access to Users'],
            ['name' => PermissionTypes::ACCOUNT_CREATE_ACCESS, 'display' => 'Permission to Create Users'],
            ['name' => PermissionTypes::ACCOUNT_READ_ACCESS, 'display' => 'Permission to View Users'],
            ['name' => PermissionTypes::ACCOUNT_DELETE_ACCESS, 'display' => 'Permission to Delete Users'],

            ['name' => PermissionTypes::ROLE_FULL_ACCESS, 'display' => 'Full Access to Roles'],
            ['name' => PermissionTypes::ROLE_CREATE_ACCESS, 'display' => 'Permission to Create Roles'],
            ['name' => PermissionTypes::ROLE_READ_ACCESS, 'display' => 'Permission to View Roles'],
            ['name' => PermissionTypes::ROLE_DELETE_ACCESS, 'display' => 'Permission to Delete Roles'],
        ]);

        $permissions->each(function ($permission) {
            Permission::firstOrCreate(['name' => $permission['name']->value, 'display' => $permission['display']]);
        });
    }
}
