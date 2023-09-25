<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\Constant\PlanConstant;
use App\Domains\Enum\Plan\PlanStatusEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->uuid(PlanConstant::ID)->unique()->primary();
            $table->string(PlanConstant::NAME)->unique();
            $table->string(PlanConstant::DESCRIPTION);
            $table->string(PlanConstant::PRECEDING_PLAN_NAME)->index()->nullable();
            $table->json(PlanConstant::OFFERS)->nullable();
            $table->enum(PlanConstant::STATUS, PlanStatusEnum::values())->default(PlanStatusEnum::ACTIVE->value);
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
