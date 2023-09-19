<?php

namespace Database\Seeders;

use App\Domains\Constant\TenantConstant;
use App\Domains\Enum\Tenant\TenantStatusEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tenant;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Tenant::create([
            TenantConstant::NAME => 'Rayda',
            TenantConstant::SUB_DOMAIN => 'rayda',
            TenantConstant::STATUS => TenantStatusEnum::ACTIVE->value,
        ]);
    }
}
