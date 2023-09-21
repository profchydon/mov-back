<?php

use App\Domains\Constant\CommonConstant;
use Illuminate\Support\Facades\Schema;
use App\Domains\Constant\SubscriptionConstant;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Domains\Enum\Subscription\SubscriptionStatusEnum;
use App\Domains\Enum\Plan\BillingCycleEnum;
use App\Models\Tenant;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\Plan;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->uuid(SubscriptionConstant::ID)->unique()->primary();
            $table->string(SubscriptionConstant::TENANT_ID)->references(CommonConstant::ID)->on(Tenant::getTableName());
            $table->string(SubscriptionConstant::COMPANY_ID)->references(CommonConstant::ID)->on(Company::getTableName());
            $table->string(SubscriptionConstant::PLAN_ID)->references(CommonConstant::ID)->on(Plan::getTableName());
            $table->string(SubscriptionConstant::INVOICE_ID)->references(CommonConstant::ID)->on(Invoice::getTableName());
            $table->dateTime(SubscriptionConstant::START_DATE);
            $table->dateTime(SubscriptionConstant::END_DATE);
            $table->enum(SubscriptionConstant::BILLING_CYCLE, BillingCycleEnum::values());
            $table->enum(SubscriptionConstant::STATUS, SubscriptionStatusEnum::values())->default(SubscriptionStatusEnum::INACTIVE->value);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
