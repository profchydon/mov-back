<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $tenant = Company::limit(1)->get();

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
