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
            // $table->dropColumn(\App\Domains\Constant\Plan\PlanProcessorConstant::PLAN_PROCESSOR_NAME);
            // $table->dropColumn(\App\Domains\Constant\Plan\PlanProcessorConstant::PLAN_PRICE_ID);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plan_processors', function (Blueprint $table) {
//             $table->foreignUuid(\App\Domains\Constant\Plan\PlanProcessorConstant::PLAN_ID)->nullable()->references(\App\Domains\Constant\Plan\PlanProcessorConstant::ID)->on(\App\Models\Plan::getTableName());
//             $table->foreignUuid(\App\Domains\Constant\Plan\PlanProcessorConstant::PLAN_PRICE_ID)->nullable()->references(\App\Domains\Constant\Plan\PlanProcessorConstant::ID)->on(\App\Models\PlanPrice::getTableName());
        });
    }
};
