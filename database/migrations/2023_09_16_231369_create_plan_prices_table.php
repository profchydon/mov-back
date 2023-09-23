<?php

use App\Domains\Constant\CommonConstant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\Constant\PlanPriceConstant;
use App\Domains\Constant\PlanConstant;
use App\Domains\Enum\Plan\BillingCycleEnum;
use App\Models\Currency;
use App\Models\Plan;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('plan_prices', function (Blueprint $table) {
            $table->uuid(PlanPriceConstant::ID)->unique()->primary();
            $table->foreign(PlanPriceConstant::PLAN_ID)->references(PlanConstant::ID)->on(Plan::getTableName());
            $table->foreign(PlanPriceConstant::CURRENCY_CODE)->references(CommonConstant::CODE)->on(Currency::getTableName());
            $table->double(PlanPriceConstant::AMOUNT);
            $table->enum(PlanPriceConstant::BILLING_CYCLE, BillingCycleEnum::values());
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_prices');
    }
};
