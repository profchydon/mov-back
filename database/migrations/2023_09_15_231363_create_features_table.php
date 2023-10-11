<?php

use App\Domains\Constant\FeatureConstant;
use App\Domains\Enum\Feature\FeaturePriceEnum;
use App\Domains\Enum\Feature\FeatureStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('features', function (Blueprint $table) {
            $table->uuid(FeatureConstant::ID)->unique()->primary();
            $table->string(FeatureConstant::NAME)->unique();
            $table->boolean(FeatureConstant::AVAILABLE_AS_ADDON)->default(false);
            $table->enum(FeatureConstant::PRICING, FeaturePriceEnum::values())->default(FeaturePriceEnum::PAID->value);
            $table->enum(FeatureConstant::STATUS, FeatureStatusEnum::values())->default(FeatureStatusEnum::ACTIVE->value);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('features');
    }
};
