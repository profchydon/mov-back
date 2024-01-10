<?php

use App\Domains\Constant\CommonConstant;
use App\Domains\Constant\DamagedAssetConstant;
use App\Models\Asset;
use App\Models\Company;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('damaged_assets', function (Blueprint $table) {
            $table->uuid(DamagedAssetConstant::ID)->unique()->primary();
            $table->foreignUuid(DamagedAssetConstant::COMPANY_ID)->references(CommonConstant::ID)->on(Company::getTableName())->onDelete('cascade');
            $table->foreignUuid(DamagedAssetConstant::ASSET_ID)->references(CommonConstant::ID)->on(Asset::getTableName())->onDelete('cascade');
            $table->date(DamagedAssetConstant::DATE);
            $table->string(DamagedAssetConstant::COMMENT);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('damaged_assets');
    }
};
