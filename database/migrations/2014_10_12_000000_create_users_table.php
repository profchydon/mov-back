<?php

use App\Domains\Constant\TenantConstant;
use App\Domains\Constant\UserConstant;
use App\Domains\Enum\User\UserStageEnum;
use App\Domains\Enum\User\UserStatusEnum;
use App\Models\Country;
use App\Models\Tenant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid(UserConstant::ID)->unique()->primary();
            $table->string(UserConstant::FIRST_NAME)->nullable();
            $table->string(UserConstant::LAST_NAME)->nullable();
            $table->string(UserConstant::EMAIL)->unique();
            $table->string(UserConstant::PHONE)->nullable();
            $table->uuid(UserConstant::SSO_ID)->nullable();
            $table->foreignUuid(UserConstant::TENANT_ID)->nullable()->references(TenantConstant::ID)->on(Tenant::getTableName());
            $table->foreignIdFor(Country::class, UserConstant::COUNTRY_ID)->nullable();
            $table->enum(UserConstant::STAGE, UserStageEnum::values())->default(UserStageEnum::VERIFICATION->value);
            $table->enum(UserConstant::STATUS, UserStatusEnum::values())->default(UserStatusEnum::ACTIVE->value);
            $table->dateTimeTz(UserConstant::LAST_LOGIN)->nullable();
            $table->dateTimeTz(UserConstant::EMAIL_VERIFIED_AT)->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });


        // Turn on RLS
        // DB::statement('ALTER TABLE users ENABLE ROW LEVEL SECURITY;');

        // // Restrict read and write actions so tenants can only see their rows
        // // Cast the UUID value in tenant_id to match the type current_user returns
        // // This policy implies a WITH CHECK that matches the USING clause
        // DB::statement('CREATE POLICY tenant_user_isolation_policy ON users USING (tenant_id::TEXT = current_user);');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
