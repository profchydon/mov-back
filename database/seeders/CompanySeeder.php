<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $tenant = Tenant::limit(1)->get();

        Company::create([
            'name' => 'Rayda',
            'size' => '1 - 10',
            'phone' => '+234700000000',
            'industry' => 'Financial technology',
            'country' => 150,
            'tenant_id' => $tenant[0]->id,
            'status' => 'ACTIVE'
        ]);
    }
}
