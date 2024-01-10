<?php

use App\Domains\Constant\CommonConstant;
use App\Domains\Constant\RetiredAssetConstant;
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
        Schema::create('retired_assets', function (Blueprint $table) {
            $table->uuid(RetiredAssetConstant::ID)->unique()->primary();
            $table->foreignUuid(RetiredAssetConstant::COMPANY_ID)->references(CommonConstant::ID)->on(Company::getTableName())->onDelete('cascade');
            $table->foreignUuid(RetiredAssetConstant::ASSET_ID)->references(CommonConstant::ID)->on(Asset::getTableName())->onDelete('cascade');
            $table->date(RetiredAssetConstant::DATE);
            $table->string(RetiredAssetConstant::REASON);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retired_assets');
    }
};
