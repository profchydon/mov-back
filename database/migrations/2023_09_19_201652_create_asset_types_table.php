<?php

use App\Domains\Constant\Asset\AssetConstant;
use App\Domains\Enum\Asset\AssetTypeStatusEnum;
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
            $table->enum(AssetConstant::STATUS, AssetTypeStatusEnum::values())->default(AssetTypeStatusEnum::ACTIVE->value);
            $table->timestamps();
            $table->softDeletes();
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
