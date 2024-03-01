<?php

namespace App\Console\Commands;

use App\Domains\Constant\Plan\PlanConstant;
use App\Domains\Constant\SubscriptionConstant;
use App\Domains\Enum\Plan\BillingCycleEnum;
use App\Domains\Enum\Subscription\SubscriptionStatusEnum;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DeactivateExpiredSubscription extends Command
{

    protected $signature = 'app:deactivate-expired-subscription';


    protected $description = 'Update the statuses of all expired subscriptions';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $this->info('Deactivating expired subscriptions...');

        $updatedRecords = Subscription::where('status', SubscriptionStatusEnum::ACTIVE)
            ->where('end_date', '<=', now()->format('Y-m-d'))
            ->get();

            foreach ($updatedRecords as $updatedRecord) {

                DB::beginTransaction();
                $updatedRecord->update([
                    SubscriptionConstant::STATUS => SubscriptionStatusEnum::EXPIRED->value
                ]);

                $company = $updatedRecord->company;
                $plan = Plan::where(PlanConstant::NAME, 'Basic')->first();

                $startDate = Carbon::now();
                $endDate = $startDate->addYear();

                $company->subscriptions()->create([
                    SubscriptionConstant::TENANT_ID => $company->tenant?->id,
                    SubscriptionConstant::PLAN_ID => $plan->id,
                    SubscriptionConstant::START_DATE => $startDate,
                    SubscriptionConstant::END_DATE => $endDate,
                    SubscriptionConstant::BILLING_CYCLE => BillingCycleEnum::YEARLY->value,
                    SubscriptionConstant::STATUS => SubscriptionStatusEnum::ACTIVE->value
                ]);

                DB::commit();
            }

        // $this->info("Updated {$updatedRecords} subscription(s) to expired");
    }
}
