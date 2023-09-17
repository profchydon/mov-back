<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\Constant\CompanyConstant;
use App\Domains\Constant\UserConstant;
use App\Domains\Constant\TenantConstant;
use App\Domains\Enum\Company\CompanyStatusEnum;
use App\Models\Company;
use App\Models\Tenant;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->uuid(CompanyConstant::ID)->unique()->primary();
            $table->string(CompanyConstant::NAME);
            $table->string(CompanyConstant::SIZE)->nullable();
            $table->string(CompanyConstant::PHONE)->nullable();
            $table->string(CompanyConstant::INDUSTRY)->nullable();
            $table->string(CompanyConstant::COUNTRY)->nullable();
            $table->string(CompanyConstant::TENANT_ID)->unique()->references(TenantConstant::ID)->on(Tenant::getTableName());
            $table->enum(CompanyConstant::STATUS, CompanyStatusEnum::values())->default(CompanyStatusEnum::ACTIVE->value);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
