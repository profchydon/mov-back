<?php

use App\Domains\Constant\CommonConstant;
use App\Domains\Constant\OfficeConstant;
use App\Domains\Enum\Office\OfficeStatusEnum;
use App\Models\Company;
use App\Models\Currency;
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
        Schema::create('offices', function (Blueprint $table) {
            $table->uuid(OfficeConstant::ID)->unique()->primary();
            $table->string(OfficeConstant::TENANT_ID)->references(CommonConstant::ID)->on(Tenant::getTableName());
            $table->string(OfficeConstant::COMPANY_ID)->references(CommonConstant::ID)->on(Company::getTableName());
            $table->string(OfficeConstant::NAME);
            $table->string(OfficeConstant::ADDRESS);
            $table->string(OfficeConstant::CURRENCY_ID)->references(CommonConstant::ID)->on(Currency::getTableName());
            $table->string(OfficeConstant::COUNTRY);
            $table->string(OfficeConstant::STATE);
            $table->string(OfficeConstant::LATITUDE)->nullable();
            $table->string(OfficeConstant::LONGITUDE)->nullable();
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
        Schema::dropIfExists('offices');
    }
};
