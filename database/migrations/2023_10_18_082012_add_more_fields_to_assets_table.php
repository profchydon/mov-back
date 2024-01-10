<?php

use App\Domains\Constant\Asset\AssetConstant;
use App\Domains\Constant\CommonConstant;
use App\Domains\Enum\Asset\AssetAcquisitionTypeEnum;
use App\Models\Vendor;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->enum(AssetConstant::ACQUISITION_TYPE, AssetAcquisitionTypeEnum::values())->nullable();
            $table->foreignUuid(AssetConstant::VENDOR_ID)->nullable()->references(CommonConstant::ID)->on(Vendor::getTableName());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn(AssetConstant::ACQUISITION_TYPE);
            $table->dropColumn(AssetConstant::VENDOR_ID);
        });
    }
};
