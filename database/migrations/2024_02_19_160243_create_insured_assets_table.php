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
        Schema::create('insured_assets', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid(\App\Domains\Constant\InsuranceConstant::INSURANCE_ID)->constrained(\App\Models\Insurance::getTableName());
            $table->foreignUuid(\App\Domains\Constant\InsuranceConstant::ASSET_ID)->constrained(\App\Models\Asset::getTableName());
            $table->timestamps();

            $table->unique([\App\Domains\Constant\InsuranceConstant::INSURANCE_ID, \App\Domains\Constant\InsuranceConstant::ASSET_ID]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insured_assets');
    }
};
