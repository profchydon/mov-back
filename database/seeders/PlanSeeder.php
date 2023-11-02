<?php

namespace Database\Seeders;

use App\Domains\Constant\Plan\PlanConstant;
use App\Domains\Constant\Plan\PlanPriceConstant;
use App\Domains\Constant\Plan\PlanProcessorConstant;
use App\Models\Plan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Yaml\Yaml;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $directoryPath = base_path('database/seeders/config/plans');
        $files = File::files($directoryPath);

        foreach ($files as $file) {
            $seedFile = Yaml::parseFile($file->getPathname());

            $plan = Plan::updateOrCreate([
                PlanConstant::NAME => $seedFile['name'],
            ], [
                PlanConstant::NAME => $seedFile['name'],
                PlanConstant::DESCRIPTION => $seedFile['description'],
                PlanConstant::PRECEDING_PLAN_NAME => $seedFile['preceding_plan_name'] ?? null,
                PlanConstant::OFFERS => $seedFile['offers'],
            ]);

            foreach ($seedFile['prices'] as $price) {
                $planPrice = $plan->prices()->updateOrCreate([
                    PlanPriceConstant::CURRENCY_CODE => $price['currency_code'],
                    PlanPriceConstant::BILLING_CYCLE => $price['billing_cycle'],
                ], [
                    PlanPriceConstant::CURRENCY_CODE => $price['currency_code'],
                    PlanPriceConstant::BILLING_CYCLE => $price['billing_cycle'],
                    PlanPriceConstant::AMOUNT => $price['amount'],
                ]);

                $processors = $price['processors'] ?? [];
                foreach ($processors as $processor) {
                    $planProcessor = $planPrice->processor()->updateOrCreate([
                        PlanProcessorConstant::PLAN_PROCESSOR_NAME => $processor['name'],
//                        PlanProcessorConstant::PLAN_ID => $plan->id,
                    ], [
                        PlanProcessorConstant::PLAN_PROCESSOR_ID => $processor['id'],
                    ]);

                    Log::info($planProcessor);
                }
            }
        }
    }
}
