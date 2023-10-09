<?php

use App\Domains\Constant\FeatureConstant;
use App\Domains\Constant\PlanFeatureConstant;
use App\Models\Feature;
use App\Models\Plan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('plan_features', function (Blueprint $table) {
            $table->uuid(PlanFeatureConstant::ID)->unique()->primary();
            $table->foreignUuid(PlanFeatureConstant::PLAN_ID)->references(FeatureConstant::ID)->on(Plan::getTableName());
            $table->foreignUuid(PlanFeatureConstant::FEATURE_ID)->references(FeatureConstant::ID)->on(Feature::getTableName());
            $table->string(PlanFeatureConstant::VALUE);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_features');
    }
};
