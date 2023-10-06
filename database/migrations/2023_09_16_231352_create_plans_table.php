<?php

use App\Domains\Constant\FeatureConstant;
use App\Domains\Enum\Plan\PlanStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->uuid(FeatureConstant::ID)->unique()->primary();
            $table->string(FeatureConstant::NAME)->unique();
            $table->string(FeatureConstant::DESCRIPTION)->nullable();
            $table->string(FeatureConstant::PRECEDING_PLAN_NAME)->index()->nullable();
            $table->json(FeatureConstant::OFFERS)->nullable();
            $table->enum(FeatureConstant::STATUS, PlanStatusEnum::values())->default(PlanStatusEnum::ACTIVE->value);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
