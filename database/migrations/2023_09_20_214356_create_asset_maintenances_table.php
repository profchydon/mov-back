<?php

use App\Domains\Constant\Asset\AssetMaintenanceConstant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('asset_maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid(AssetMaintenanceConstant::TENANT_ID)->references(AssetMaintenanceConstant::ID)->on(\App\Models\Tenant::getTableName());
            $table->foreignUuid(AssetMaintenanceConstant::COMPANY_ID)->references(AssetMaintenanceConstant::ID)->on(\App\Models\Company::getTableName());
            $table->foreignUuid(AssetMaintenanceConstant::ASSET_ID)->references(AssetMaintenanceConstant::ID)->on(\App\Models\Asset::getTableName());
            $table->string(AssetMaintenanceConstant::GROUP_ID, 13);
            $table->string(AssetMaintenanceConstant::REASON);
            // $table->foreignUuid(AssetMaintenanceConstant::RECEIVER_ID)->references(AssetMaintenanceConstant::ID)->on(\App\Models\User::getTableName());
            $table->nullableUuidMorphs(AssetMaintenanceConstant::RECEIVER);
            // $table->dateTime(AssetMaintenanceConstant::SCHEDULED_DATE);
            $table->dateTime(AssetMaintenanceConstant::RETURN_DATE);
            $table->enum(AssetMaintenanceConstant::STATUS, \App\Domains\Enum\Asset\AssetMaintenanceStatusEnum::values())->default(\App\Domains\Enum\Asset\AssetMaintenanceStatusEnum::LOGGED->value);
            $table->text(AssetMaintenanceConstant::COMMENT)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_maintenances');
    }
};
