<?php

use App\Domains\Constant\Asset\AssetConstant;
use App\Domains\Enum\Maintenance\MaintenanceCycleEnum;
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
            $table->enum(AssetConstant::MAINTENANCE_CYCLE, MaintenanceCycleEnum::values())->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
        });
    }
};
