<?php

use App\Domains\Constant\CommonConstant;
use App\Domains\Constant\UserInvitationConstant;
use App\Models\Department;
use App\Models\Office;
use App\Models\Team;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_invitations', function (Blueprint $table) {
            $table->string(UserInvitationConstant::NAME)->nullable();
            $table->string(UserInvitationConstant::JOB_TITLE)->nullable();
            $table->string(UserInvitationConstant::EMPLOYMENT_TYPE)->nullable();
            $table->foreignUuid(UserInvitationConstant::OFFICE_ID)->nullable()->references(CommonConstant::ID)->on(Office::getTableName());
            $table->foreignUuid(UserInvitationConstant::DEPARTMENT_ID)->nullable()->references(CommonConstant::ID)->on(Department::getTableName());
            $table->foreignUuid(UserInvitationConstant::TEAM_ID)->nullable()->references(CommonConstant::ID)->on(Team::getTableName());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_invitations', function (Blueprint $table) {
            // $table->dropColumn(UserInvitationConstant::NAME);
            // $table->dropColumn(UserInvitationConstant::JOB_TITLE);
            // $table->dropColumn(UserInvitationConstant::EMPLOYMENT_TYPE);
            // $table->dropColumn(UserInvitationConstant::OFFICE_ID);
            // $table->dropColumn(UserInvitationConstant::DEPARTMENT_ID);
            // $table->dropColumn(UserInvitationConstant::TEAM_ID);
        });
    }
};
