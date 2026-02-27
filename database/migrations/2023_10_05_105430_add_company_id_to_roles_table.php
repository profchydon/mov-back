<?php

use App\Domains\Constant\CommonConstant;
use App\Models\Company;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->foreignUuid(CommonConstant::COMPANY_ID)->nullable()->references(CommonConstant::ID)->on(Company::getTableName());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            // $table->dropColumn(CommonConstant::COMPANY_ID);
        });
    }
};
