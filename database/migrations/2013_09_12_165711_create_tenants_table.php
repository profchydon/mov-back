<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\Constant\TenantConstant;
use App\Domains\Enum\Tenant\TenantStatusEnum;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->uuid(TenantConstant::ID)->unique()->primary();
            $table->string(TenantConstant::NAME);
            $table->string(TenantConstant::SUB_DOMAIN)->nullable();
            $table->enum(TenantConstant::STATUS, TenantStatusEnum::values())->default(TenantStatusEnum::ACTIVE->value);
            $table->timestamps();
            $table->softDeletes();
        });

         // Turn on RLS
        //  DB::statement('ALTER TABLE tenants ENABLE ROW LEVEL SECURITY;');

        //  // Restrict read and write actions so tenants can only see their rows
        //  // Cast the UUID value in id to match the type current_user returns
        //  DB::statement('CREATE POLICY tenant_isolation_policy ON tenants USING (id::TEXT = current_user);');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
