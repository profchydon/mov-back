<?php

use App\Domains\Constant\CommonConstant;
use App\Domains\Constant\SubscriptionConstant;
use App\Domains\Enum\Plan\BillingCycleEnum;
use App\Domains\Enum\Subscription\SubscriptionStatusEnum;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\Plan;
use App\Models\Tenant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->uuid(SubscriptionConstant::ID)->unique()->primary();
            $table->foreignUuid(SubscriptionConstant::TENANT_ID)->references(CommonConstant::ID)->on(Tenant::getTableName());
            $table->foreignUuid(SubscriptionConstant::COMPANY_ID)->references(CommonConstant::ID)->on(Company::getTableName());
            $table->foreignUuid(SubscriptionConstant::PLAN_ID)->references(CommonConstant::ID)->on(Plan::getTableName());
            $table->foreignUuid(SubscriptionConstant::INVOICE_ID)->nullable()->references(CommonConstant::ID)->on(Invoice::getTableName());
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
