<?php

use App\Domains\Constant\AssetConstant;
use App\Domains\Enum\Asset\AssetTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('asset_types', function (Blueprint $table) {
            $table->uuid(AssetConstant::ID)->unique()->primary();
            $table->string(AssetConstant::NAME);
            $table->enum(AssetConstant::STATUS, AssetTypeEnum::values())->default(AssetTypeEnum::ACTIVE->value);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_types');
    }
};
