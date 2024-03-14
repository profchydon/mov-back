<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('plan_processors', function (Blueprint $table) {
            $table->string(\App\Domains\Constant\Plan\PlanProcessorConstant::PLAN_PRICE_SLUG)->constrained('plan_prices', 'slug')->nullable();
            $table->string(\App\Domains\Constant\Plan\PlanProcessorConstant::PAYMENT_PROCESSOR_SLUG)->constrained('payment_processor', 'slug')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plan_processors', function (Blueprint $table) {
            $table->dropColumn(\App\Domains\Constant\Plan\PlanProcessorConstant::PLAN_PRICE_SLUG);
            $table->dropColumn(\App\Domains\Constant\Plan\PlanProcessorConstant::PAYMENT_PROCESSOR_SLUG);
        });
    }
};
