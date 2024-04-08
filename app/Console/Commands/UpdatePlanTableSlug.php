<?php

namespace App\Console\Commands;

use App\Models\Plan;
use App\Models\PlanPrice;
use App\Models\PlanProcessor;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UpdatePlanTableSlug extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-plan-table-slug';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
//        Plan::chunk(50, function ($models) {
//            foreach ($models as $model) {
//                $model->slug = Str::slug($model->name);
//                $model->save();
//            }
//        });
//
//
//        PlanPrice::chunk(50, function ($models) {
//            foreach ($models as $model) {
//                $planName = $model->plan->name;
//                $model->slug = Str::slug("{$planName} {$model->currency_code} {$model->billing_cycle->value}");
//                $model->plan_slug = Str::slug($planName);
//                $model->save();
//            }
//        });

        PlanProcessor::chunk(50, function($models){
            foreach ($models as $model){
                $model->plan_price_slug = $model->planPrice->slug;
                $model->payment_processor_slug = Str::slug($model->plan_processor_name);
                $model->save();
            }
        });

    }
}
