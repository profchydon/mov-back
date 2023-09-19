<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\Constant\UserConstant;
use App\Domains\Constant\TenantConstant;
use App\Domains\Enum\User\UserStatusEnum;
use App\Models\Tenant;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid(UserConstant::ID)->unique()->primary();
            $table->string(UserConstant::FIRST_NAME);
            $table->string(UserConstant::LAST_NAME);
            $table->string(UserConstant::EMAIL)->unique();
            $table->string(UserConstant::PASSWORD);
            $table->string(UserConstant::PHONE_CODE)->nullable();
            $table->string(UserConstant::PHONE)->nullable();
            $table->string(UserConstant::COUNTRY_ID)->nullable();
            $table->string(UserConstant::STAGE)->nullable();
            $table->enum(UserConstant::STATUS, UserStatusEnum::values())->default(UserStatusEnum::ACTIVE->value);
            $table->dateTimeTz(UserConstant::LAST_LOGIN)->nullable();
            $table->dateTimeTz(UserConstant::EMAIL_VERIFIED_AT)->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
