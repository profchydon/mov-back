<?php

use App\Domains\Constant\CommonConstant;
use App\Domains\Constant\UserCompanyConstant;
use App\Domains\Enum\User\UserCompanyStatusEnum;
use App\Models\Company;
use App\Models\Office;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_companies', function (Blueprint $table) {
            $table->uuid(UserCompanyConstant::ID)->unique()->primary();
            $table->foreignUuid(UserCompanyConstant::TENANT_ID)->references(UserCompanyConstant::ID)->on(Tenant::getTableName());
            $table->foreignUuid(UserCompanyConstant::COMPANY_ID)->references(UserCompanyConstant::ID)->on(Company::getTableName())->onDelete('cascade');
            $table->foreignUuid(UserCompanyConstant::USER_ID)->references(UserCompanyConstant::ID)->on(User::getTableName())->onDelete('cascade');
            $table->foreignUuid(UserCompanyConstant::OFFICE_ID)->nullable()->references(CommonConstant::ID)->on(Office::getTableName());
            $table->enum(UserCompanyConstant::STATUS, UserCompanyStatusEnum::values())->default(UserCompanyStatusEnum::ACTIVE->value);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_companies');
    }
};
