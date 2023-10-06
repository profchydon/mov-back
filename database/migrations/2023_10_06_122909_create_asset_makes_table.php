<?php

use App\Domains\Constant\AssetMakeConstant;
use App\Domains\Constant\CommonConstant;
use App\Domains\Enum\Asset\AssetMakeStatusEnum;
use App\Models\Company;
use App\Models\Tenant;
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
        Schema::create('asset_makes', function (Blueprint $table) {
            $table->uuid(AssetMakeConstant::ID)->unique()->primary();
            $table->foreignUuid(AssetMakeConstant::TENANT_ID)->references(CommonConstant::ID)->on(Tenant::getTableName());
            $table->foreignUuid(AssetMakeConstant::COMPANY_ID)->references(CommonConstant::ID)->on(Company::getTableName());
            $table->string(AssetMakeConstant::NAME);
            $table->enum(AssetMakeConstant::STATUS, AssetMakeStatusEnum::values())->default(AssetMakeStatusEnum::ACTIVE->value);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_makes');
    }
};
