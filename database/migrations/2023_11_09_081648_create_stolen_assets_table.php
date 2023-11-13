<?php

use App\Domains\Constant\CommonConstant;
use App\Domains\Constant\StolenAssetConstant;
use App\Models\Asset;
use App\Models\Company;
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
        Schema::create('stolen_assets', function (Blueprint $table) {
            $table->uuid(StolenAssetConstant::ID)->unique()->primary();
            $table->foreignUuid(StolenAssetConstant::COMPANY_ID)->references(CommonConstant::ID)->on(Company::getTableName())->onDelete('cascade');
            $table->foreignUuid(StolenAssetConstant::ASSET_ID)->references(CommonConstant::ID)->on(Asset::getTableName())->onDelete('cascade');
            $table->date(StolenAssetConstant::DATE);
            $table->string(StolenAssetConstant::COMMENT);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stolen_assets');
    }
};
