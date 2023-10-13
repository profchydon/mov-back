<?php

use App\Domains\Constant\AssetCheckoutConstant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('asset_checkouts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid(AssetCheckoutConstant::TENANT_ID)->references(AssetCheckoutConstant::ID)->on(\App\Models\Tenant::getTableName());
            $table->foreignUuid(AssetCheckoutConstant::COMPANY_ID)->references(AssetCheckoutConstant::ID)->on(\App\Models\Company::getTableName());
            $table->foreignUuid(AssetCheckoutConstant::ASSET_ID)->references(AssetCheckoutConstant::ID)->on(\App\Models\Asset::getTableName());
            $table->string(AssetCheckoutConstant::GROUP_ID, 13);
            $table->string(AssetCheckoutConstant::REASON);
            $table->nullableUuidMorphs(AssetCheckoutConstant::RECEIVER);
            $table->dateTime(AssetCheckoutConstant::CHECKOUT_DATE);
            $table->dateTime(AssetCheckoutConstant::RETURN_DATE);
            $table->enum(AssetCheckoutConstant::STATUS, \App\Domains\Enum\Asset\AssetCheckoutStatusEnum::values())->default(\App\Domains\Enum\Asset\AssetCheckoutStatusEnum::CHECKED_OUT->value);
            $table->text(AssetCheckoutConstant::COMMENT)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_checkouts');
    }
};
