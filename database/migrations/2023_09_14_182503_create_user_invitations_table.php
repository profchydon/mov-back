<?php

use App\Domains\Constant\UserInvitationConstant;
use App\Domains\Enum\User\UserInvitationStatusEnum;
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
        Schema::create('user_invitations', function (Blueprint $table) {
            $table->uuid(UserInvitationConstant::ID)->unique()->primary();
            $table->string(UserInvitationConstant::EMAIL);
            $table->bigInteger(UserInvitationConstant::ROLE)->references('id')->on('roles');;
            $table->string(UserInvitationConstant::CODE);
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
