<?php

namespace Database\Seeders;

use App\Domains\Auth\RoleTypes;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = collect([
            RoleTypes::ADMINISTRATOR,
            RoleTypes::ASSET_MANAGER,
            RoleTypes::TECHNICIAN,
            RoleTypes::FINANCE,
            RoleTypes::BASIC,
        ]);

        $roles->each(function ($role) {
            $dbRole = Role::firstOrCreate(['name' => $role->value]);

            if ($role == RoleTypes::ADMINISTRATOR) {
                $permissions = Permission::all();

                $dbRole->syncPermissions($permissions);
            }
        });
    }
}
