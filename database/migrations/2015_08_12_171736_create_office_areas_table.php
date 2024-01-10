<?php

use App\Domains\Constant\CommonConstant;
use App\Domains\Constant\OfficeConstant;
use App\Domains\Enum\Office\OfficeStatusEnum;
use App\Models\Office;
use App\Models\Tenant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('office_areas', function (Blueprint $table) {
            $table->uuid(OfficeConstant::ID)->unique()->primary();
            $table->foreignUuid(OfficeConstant::TENANT_ID)->references(CommonConstant::ID)->on(Tenant::getTableName());
            $table->foreignUuid(OfficeConstant::OFFICE_ID)->references(CommonConstant::ID)->on(Office::getTableName());
            $table->string(OfficeConstant::NAME);
            $table->enum(OfficeConstant::STATUS, OfficeStatusEnum::values())->default(OfficeStatusEnum::ACTIVE->value);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('office_areas');
    }
};
