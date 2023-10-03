<?php

use App\Domains\Constant\UserCompanyConstant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
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
        Schema::table('user_companies', function (Blueprint $table) {
            $table->uuid(UserCompanyConstant::TENANT_ID)->references(UserCompanyConstant::ID)->on(Tenant::getTableName())->change();
            $table->uuid(UserCompanyConstant::COMPANY_ID)->references(UserCompanyConstant::ID)->on(Company::getTableName())->onDelete('cascade')->change();
            $table->uuid(UserCompanyConstant::USER_ID)->references(UserCompanyConstant::ID)->on(User::getTableName())->onDelete('cascade')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_companies', function (Blueprint $table) {
            //
        });
    }
};
