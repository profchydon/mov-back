<?php

use App\Domains\Constant\CommonConstant;
use App\Domains\Constant\UserDepartmentConstant;
use App\Domains\Enum\User\UserDepartmentStatusEnum;
use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_departments', function (Blueprint $table) {
            $table->uuid(UserDepartmentConstant::ID)->unique()->primary();
            $table->foreignUuid(UserDepartmentConstant::COMPANY_ID)->references(UserDepartmentConstant::ID)->on(Company::getTableName())->onDelete('cascade');
            $table->foreignUuid(UserDepartmentConstant::USER_ID)->references(UserDepartmentConstant::ID)->on(User::getTableName())->onDelete('cascade');
            $table->foreignUuid(UserDepartmentConstant::DEPARTMENT_ID)->nullable()->references(CommonConstant::ID)->on(Department::getTableName());
            $table->enum(UserDepartmentConstant::STATUS, UserDepartmentStatusEnum::values())->default(UserDepartmentStatusEnum::ACTIVE->value);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_departments');
    }
};
