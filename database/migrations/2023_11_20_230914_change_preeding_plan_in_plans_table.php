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
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn(\App\Domains\Constant\Plan\PlanConstant::PRECEDING_PLAN_NAME);
            $table->unsignedInteger(\App\Domains\Constant\Plan\PlanConstant::RANK)->nullable()->unique()->after(\App\Domains\Constant\Plan\PlanConstant::DESCRIPTION);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn(\App\Domains\Constant\Plan\PlanConstant::RANK);
            $table->string(\App\Domains\Constant\Plan\PlanConstant::PRECEDING_PLAN_NAME)->index()->nullable();
        });
    }
};
