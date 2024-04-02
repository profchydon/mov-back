<?php

namespace Database\Seeders;

use App\Domains\Constant\FeatureConstant;
use App\Domains\Constant\Plan\PlanConstant;
use App\Domains\Constant\Plan\PlanFeatureConstant;
use App\Domains\Constant\Plan\PlanPriceConstant;
use App\Domains\Constant\Plan\PlanProcessorConstant;
use App\Models\Feature;
use App\Models\Plan;
use App\Models\PlanProcessor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Spatie\LaravelIgnition\Recorders\DumpRecorder\Dump;
use Symfony\Component\Yaml\Yaml;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        Plan::truncate();
//        PlanProcessor::truncate();

        if (env('APP_ENV') === 'production') {
            $directoryPath = base_path('database/seeders/config/plans');
            $files = File::files($directoryPath);
            @dump("Production Seed: " . count($files) . " Plans");
        }else {
            $directoryPath = base_path('database/seeders/config/plans-dev');
            $files = File::files($directoryPath);
            @dump("Dev Seed: " . count($files) . " Plans");
        }

        foreach ($files as $file) {
            $seedFile = Yaml::parseFile($file->getPathname());

            $plan = Plan::updateOrCreate([
                PlanConstant::NAME => $seedFile['name'],
            ], [
                PlanConstant::NAME => $seedFile['name'],
                PlanConstant::DESCRIPTION => $seedFile['description'],
                PlanConstant::RANK => $seedFile['rank'] ?? null,
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
                    $planPrice->processor()->updateOrCreate([
                        PlanProcessorConstant::PLAN_PROCESSOR_NAME => $processor['name'],
                    ], [
                        PlanProcessorConstant::PLAN_PROCESSOR_ID => $processor['id'],
                        PlanProcessorConstant::PLAN_PRICE_SLUG => $price['slug'],
                        PlanProcessorConstant::PAYMENT_PROCESSOR_SLUG => strtolower($processor['name']),
                    ]);
                }
            }

            foreach ($seedFile['features'] as $planFeature) {
                $feature = Feature::where(FeatureConstant::NAME, $planFeature['name'])->first();

                $plan->planFeatures()->updateOrCreate([
                    PlanFeatureConstant::PLAN_ID => $plan->id,
                    PlanFeatureConstant::FEATURE_ID => $feature->id,
                ], [
                    PlanFeatureConstant::VALUE => $planFeature['value'],
                ]);
            }
        }
    }
}
