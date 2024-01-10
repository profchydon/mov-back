<?php

use App\Domains\Constant\DepartmentConstant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->uuid(DepartmentConstant::ID)->unique()->primary();
            $table->foreignUuid(DepartmentConstant::TENANT_ID)->references(\App\Domains\Constant\CommonConstant::ID)->on(\App\Models\Tenant::getTableName());
            $table->foreignUuid(DepartmentConstant::COMPANY_ID)->references(\App\Domains\Constant\CommonConstant::ID)->on(\App\Models\Company::getTableName());
            $table->string(DepartmentConstant::NAME);
            $table->foreignUuid(DepartmentConstant::HEAD_ID)->unique()->nullable()->references(\App\Domains\Constant\CommonConstant::ID)->on(\App\Models\User::getTableName());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
