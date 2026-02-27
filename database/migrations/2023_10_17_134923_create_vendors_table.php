<?php

use App\Domains\Constant\CommonConstant;
use App\Domains\Constant\VendorConstant;
use App\Domains\Enum\VendorStatusEnum;
use App\Models\Company;
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
        Schema::create('vendors', function (Blueprint $table) {
            $table->uuid(VendorConstant::ID)->unique()->primary();
            $table->foreignUuid(VendorConstant::TENANT_ID)->references(CommonConstant::ID)->on(Tenant::getTableName());
            $table->foreignUuid(VendorConstant::COMPANY_ID)->references(CommonConstant::ID)->on(Company::getTableName());
            $table->string(VendorConstant::NAME);
            $table->string(VendorConstant::EMAIL)->nullable();
            $table->string(VendorConstant::PHONE)->nullable();
            $table->string(VendorConstant::ADDRESS)->nullable();
            $table->enum(VendorConstant::STATUS, VendorStatusEnum::values())->default(VendorStatusEnum::ACTIVE->value);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('vendors');
    }
};
