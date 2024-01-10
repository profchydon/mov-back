<?php

use App\Domains\Constant\CommonConstant;
use App\Domains\Constant\UserInvitationConstant;
use App\Domains\Enum\User\UserInvitationStatusEnum;
use App\Models\Company;
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
        Schema::create('user_invitations', function (Blueprint $table) {
            $table->uuid(UserInvitationConstant::ID)->unique()->primary();
            $table->string(UserInvitationConstant::EMAIL);
            $table->foreignId(UserInvitationConstant::ROLE_ID)->references('id')->on('roles');
            $table->string(UserInvitationConstant::CODE);
            $table->foreignUuid(UserInvitationConstant::COMPANY_ID)->references(CommonConstant::ID)->on(Company::getTableName())->onDelete('cascade');
            $table->foreignUuid(UserInvitationConstant::INVITED_BY)->references(CommonConstant::ID)->on(User::getTableName())->onDelete('cascade');
            $table->string(UserInvitationConstant::STATUS)->default(UserInvitationStatusEnum::PENDING->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_invitations');
    }
};
