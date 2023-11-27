<?php

use App\Domains\Constant\CommonConstant;
use App\Domains\Constant\TeamConstant;
use App\Models\Company;
use App\Models\Department;
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
        Schema::create('teams', function (Blueprint $table) {
            $table->uuid(TeamConstant::ID)->unique()->primary();
            $table->string(TeamConstant::NAME);
            $table->foreignUuid(TeamConstant::TENANT_ID)->references(CommonConstant::ID)->on(Tenant::getTableName());
            $table->foreignUuid(TeamConstant::COMPANY_ID)->references(CommonConstant::ID)->on(Company::getTableName());
            $table->foreignUuid(TeamConstant::DEPARTMENT_ID)->references(CommonConstant::ID)->on(Department::getTableName());
            $table->foreignUuid(TeamConstant::TEAM_LEAD)->nullable()->references(CommonConstant::ID)->on(User::getTableName());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
