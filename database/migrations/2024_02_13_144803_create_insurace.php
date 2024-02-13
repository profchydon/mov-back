<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\Constant\InsuranceConstant;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('insurances', function (Blueprint $table) {
            $table->uuid(InsuranceConstant::ID)->primary();
            $table->string(InsuranceConstant::PROVIDER);
            $table->string(InsuranceConstant::POLICY_ID);
            $table->foreignUuid(InsuranceConstant::COMPANY_ID)->constrained(\App\Models\Company::getTableName());
            $table->foreignUuid(InsuranceConstant::TENANT_ID)->constrained(\App\Models\Tenant::getTableName());
            $table->date(InsuranceConstant::PURCHASE_DATE);
            $table->date(InsuranceConstant::EXPIRATION_DATE);
            $table->double(InsuranceConstant::ASSET_PREMIUM)->nullable();
            $table->double(InsuranceConstant::MAX_NUM_OF_ASSETS);
            $table->double(InsuranceConstant::COVERAGE_PERCENTAGE)->nullable();
            $table->string(InsuranceConstant::COVERAGE_CYCLE)->nullable();
            $table->string(InsuranceConstant::COUNTRY)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurace');
    }
};
