<?php

use App\Domains\Constant\CommonConstant;
use App\Domains\Constant\UserTeamConstant;
use App\Domains\Enum\User\UserTeamStatusEnum;
use App\Models\Company;
use App\Models\Department;
use App\Models\Team;
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
        Schema::create('user_teams', function (Blueprint $table) {
            $table->uuid(UserTeamConstant::ID)->unique()->primary();
            $table->foreignUuid(UserTeamConstant::COMPANY_ID)->references(UserTeamConstant::ID)->on(Company::getTableName())->onDelete('cascade');
            $table->foreignUuid(UserTeamConstant::USER_ID)->references(UserTeamConstant::ID)->on(User::getTableName())->onDelete('cascade');
            $table->foreignUuid(UserTeamConstant::DEPARTMENT_ID)->nullable()->references(CommonConstant::ID)->on(Department::getTableName());
            $table->foreignUuid(UserTeamConstant::TEAM_ID)->nullable()->references(CommonConstant::ID)->on(Team::getTableName());
            $table->enum(UserTeamConstant::STATUS, UserTeamStatusEnum::values())->default(UserTeamStatusEnum::ACTIVE->value);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_teams');
    }
};
