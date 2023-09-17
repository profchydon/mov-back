<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\Constant\FeatureConstant;
use App\Domains\Constant\FeaturePriceConstant;
use App\Models\Feature;
use App\Models\Currency;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('feature_prices', function (Blueprint $table) {
            $table->uuid(FeaturePriceConstant::ID)->unique()->primary();
            $table->uuid(FeaturePriceConstant::FEATURE_ID)->references(FeatureConstant::ID)->on(Feature::getTableName());
            $table->foreignIdFor(Currency::class, FeaturePriceConstant::CURRENCY_ID);
            $table->double(FeaturePriceConstant::PRICE);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feature_prices');
    }
};
