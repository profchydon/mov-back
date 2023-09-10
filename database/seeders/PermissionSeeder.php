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
            ['name' => PermissionTypes::ASSET_READ_ACCESS, 'display' => 'Permission to Read Asset'],
            ['name' => PermissionTypes::ASSET_TRANSFER_ACCESS, 'display' => 'Permission to Transfer Asset'],
            ['name' => PermissionTypes::BILLING_FULL_ACCESS, 'display' => 'Full Access to Billing'],
            ['name' => PermissionTypes::BILLING_CREATE_ACCESS, 'display' => 'Permission to Create Billing'],
            ['name' => PermissionTypes::BILLING_READ_ACCESS, 'display' => 'Permission to Read Billing'],
            ['name' => PermissionTypes::ACCOUNT_FULL_ACCESS, 'display' => 'Full Access to Accounts'],
            ['name' => PermissionTypes::ACCOUNT_CREATE_ACCESS, 'display' => 'Permission to Create Accounts'],
            ['name' => PermissionTypes::ACCOUNT_READ_ACCESS, 'display' => 'Permission to Read Accounts'],
        ]);

        $permissions->each(function ($permission) {
            Permission::firstOrCreate(['name' => $permission['name']->value, 'display' => $permission['display']]);
        });
    }
}
