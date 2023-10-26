<?php

use App\Domains\Constant\CommonConstant;
use App\Domains\Constant\TagConstant;
use App\Domains\Enum\Tag\TagStatusEnum;
use App\Models\Company;
use App\Models\Tenant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->uuid(TagConstant::ID)->unique()->primary();
            $table->foreignUuid(TagConstant::TENANT_ID)->references(CommonConstant::ID)->on(Tenant::getTableName());
            $table->foreignUuid(TagConstant::COMPANY_ID)->references(CommonConstant::ID)->on(Company::getTableName());
            $table->string(TagConstant::NAME);
            $table->enum(TagConstant::STATUS, TagStatusEnum::values())->default(TagStatusEnum::ACTIVE->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
