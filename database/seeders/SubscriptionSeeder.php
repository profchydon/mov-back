<?php

namespace Database\Seeders;

use App\Domains\Constant\SubscriptionConstant;
use App\Domains\Enum\Plan\BillingCycleEnum;
use App\Domains\Enum\Subscription\SubscriptionStatusEnum;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $plan = Plan::limit(1)->get();
        $invoice = Invoice::limit(1)->get();
        $company = Company::limit(1)->get();

        Subscription::create([
            SubscriptionConstant::TENANT_ID => $company[0]->tenant_id,
            SubscriptionConstant::COMPANY_ID => $company[0]->id,
            SubscriptionConstant::PLAN_ID => $plan[0]->id,
            SubscriptionConstant::INVOICE_ID => $invoice[0]->id,
            SubscriptionConstant::START_DATE => now(),
            SubscriptionConstant::END_DATE => now(),
            SubscriptionConstant::BILLING_CYCLE => BillingCycleEnum::MONTHLY->value,
            SubscriptionConstant::STATUS => SubscriptionStatusEnum::ACTIVE->value,

        ]);
    }
}
