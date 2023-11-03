<?php

use App\Domains\Constant\CommonConstant;
use App\Domains\Constant\UserInvitationConstant;
use App\Models\Department;
use App\Models\Office;
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
        Schema::table('user_invitations', function (Blueprint $table) {
            $table->string(UserInvitationConstant::NAME)->nullable();
            $table->string(UserInvitationConstant::JOB_TITLE)->nullable();
            $table->string(UserInvitationConstant::EMPLOYMENT_TYPE)->nullable();
            $table->foreignUuid(UserInvitationConstant::OFFICE_ID)->references(CommonConstant::ID)->on(Office::getTableName())->nullable();
            $table->foreignUuid(UserInvitationConstant::DEPARTMENT_ID)->references(CommonConstant::ID)->on(Department::getTableName())->nullable();
            $table->string(UserInvitationConstant::TEAM)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_invitations', function (Blueprint $table) {
            //
        });
    }
};
