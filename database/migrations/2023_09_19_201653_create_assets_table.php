<?php

use App\Domains\Constant\AssetConstant;
use App\Domains\Constant\CommonConstant;
use App\Domains\Constant\CurrencyConstant;
use App\Domains\Enum\Asset\AssetStatusEnum;
use App\Domains\Enum\Maintenance\MaintenanceCycleEnum;
use App\Models\AssetType;
use App\Models\Company;
use App\Models\Currency;
use App\Models\Office;
use App\Models\OfficeArea;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->uuid(AssetConstant::ID)->unique()->primary();
            $table->foreignUuid(AssetConstant::TENANT_ID)->references(AssetConstant::ID)->on(Tenant::getTableName());
            $table->foreignUuid(AssetConstant::COMPANY_ID)->references(AssetConstant::ID)->on(Company::getTableName());
            $table->string(AssetConstant::MAKE)->nullable();
            $table->string(AssetConstant::MODEL)->nullable();
            $table->string(AssetConstant::SERIAL_NUMBER)->nullable();
            $table->foreignUuid(AssetConstant::TYPE_ID)->references(AssetConstant::ID)->on(AssetType::getTableName());
            $table->double(AssetConstant::PURCHASE_PRICE);
            $table->dateTime(AssetConstant::PURCHASE_DATE)->nullable();
            $table->foreignUuid(AssetConstant::OFFICE_ID)->references(AssetConstant::ID)->on(Office::getTableName());
            $table->foreignUuid(AssetConstant::OFFICE_AREA_ID)->nullable()->references(AssetConstant::ID)->on(OfficeArea::getTableName());
            $table->string(AssetConstant::CURRENCY)->references(CurrencyConstant::CODE)->on(Currency::getTableName());
            $table->dateTime(AssetConstant::ADDED_AT);
            $table->foreignUuid(AssetConstant::ASSIGNED_TO)->nullable()->references(CommonConstant::ID)->on(User::getTableName());
            $table->dateTime(AssetConstant::ASSIGNED_DATE)->nullable();
            $table->enum(AssetConstant::STATUS, AssetStatusEnum::values());
            $table->enum(AssetConstant::MAINTENANCE_CYCLE, MaintenanceCycleEnum::values())->nullable();
            $table->dateTime(AssetConstant::NEXT_MAINTENANCE_DATE)->nullable();
            $table->boolean(AssetConstant::IS_INSURED)->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
