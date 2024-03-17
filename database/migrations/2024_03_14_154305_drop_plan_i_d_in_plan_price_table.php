<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('plan_prices', function (Blueprint $table) {
            $table->dropColumn(\App\Domains\Constant\Plan\PlanPriceConstant::PLAN_ID);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plan_prices', function (Blueprint $table) {
            $table->foreignUuid(\App\Domains\Constant\Plan\PlanPriceConstant::PLAN_ID)->nullable()->references(\App\Domains\Constant\FeatureConstant::ID)->on(\App\Models\Plan::getTableName());
        });
    }
};
