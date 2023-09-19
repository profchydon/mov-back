<?php

namespace Database\Seeders;

use App\Domains\Constant\PlanConstant;
use App\Domains\Enum\Plan\PlanStatusEnum;
use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Plan::create([
            PlanConstant::NAME => 'Premium Plan',
            PlanConstant::TYPE => 'PAID',
            PlanConstant::STATUS => PlanStatusEnum::ACTIVE->value,
        ]);
    }
}
