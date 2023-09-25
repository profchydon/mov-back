<?php

namespace Database\Seeders;

use App\Domains\Constant\PlanConstant;
use App\Domains\Constant\PlanPriceConstant;
use App\Domains\Enum\Plan\PlanStatusEnum;
use App\Models\Plan;
use App\Models\PlanPrice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Yaml\Yaml;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $directoryPath = base_path('database/seeders/plans');
        $files = File::files($directoryPath);

        foreach ($files as $file) {
            $seedFile = Yaml::parseFile($file->getPathname());

            $plan = Plan::updateOrCreate([
                PlanConstant::NAME => $seedFile['name']
            ], [
                PlanConstant::NAME => $seedFile['name'],
                PlanConstant::DESCRIPTION => $seedFile['description'],
                PlanConstant::PRECEDING_PLAN_NAME => $seedFile['preceding_plan_name'] ?? null
            ]);

            foreach ($seedFile['prices'] as $price) {
                $plan->prices()->updateOrCreate([
                    PlanPriceConstant::CURRENCY_CODE => $price['currency_code'],
                    PlanPriceConstant::BILLING_CYCLE => $price['billing_cycle']
                ], [
                    PlanPriceConstant::CURRENCY_CODE => $price['currency_code'],
                    PlanPriceConstant::BILLING_CYCLE => $price['billing_cycle'],
                    PlanPriceConstant::AMOUNT => $price['amount']
                ]);
            }
        }
    }
}
