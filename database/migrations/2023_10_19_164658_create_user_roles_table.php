<?php

use App\Domains\Constant\CommonConstant;
use App\Domains\Constant\UserRoleConstant;
use App\Domains\Enum\User\UserRoleStatusEnum;
use App\Models\Company;
use App\Models\Office;
use App\Models\Role;
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
        Schema::create('user_roles', function (Blueprint $table) {
            $table->uuid(UserRoleConstant::ID)->unique()->primary();
            $table->foreignUuid(UserRoleConstant::USER_ID)->references(CommonConstant::ID)->on(User::getTableName());
            $table->foreignUuid(UserRoleConstant::COMPANY_ID)->references(CommonConstant::ID)->on(Company::getTableName());
            $table->foreignUuid(UserRoleConstant::OFFICE_ID)->nullable()->references(CommonConstant::ID)->on(Office::getTableName());
            $table->foreignId(UserRoleConstant::ROLE_ID)->references(CommonConstant::ID)->on(Role::getTableName());
            $table->enum(UserRoleConstant::STATUS, UserRoleStatusEnum::values())->default(UserRoleStatusEnum::ACTIVE->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_roles');
    }
};
