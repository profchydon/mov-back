<?php

use App\Domains\Constant\Plan\PlanProcessorConstant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('plan_processors', function (Blueprint $table) {
            $table->id();
//            $table->foreignUuid(PlanProcessorConstant::PLAN_ID)->references(PlanProcessorConstant::ID)->on(\App\Models\Plan::getTableName());
            $table->foreignUuid(PlanProcessorConstant::PLAN_PRICE_ID)->references(PlanProcessorConstant::ID)->on(\App\Models\PlanPrice::getTableName());
            $table->enum(PlanProcessorConstant::PLAN_PROCESSOR_NAME, \App\Domains\Enum\Plan\PlanProcessorNameEnum::values());
            $table->string(PlanProcessorConstant::PLAN_PROCESSOR_ID);
            $table->timestamps();

            $table->unique([PlanProcessorConstant::PLAN_PRICE_ID, PlanProcessorConstant::PLAN_PROCESSOR_NAME]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_processors');
    }
};
