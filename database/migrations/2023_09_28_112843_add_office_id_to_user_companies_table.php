<?php

use App\Domains\Constant\CommonConstant;
use App\Domains\Constant\UserCompanyConstant;
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
        Schema::table('user_companies', function (Blueprint $table) {
            $table->string(UserCompanyConstant::OFFICE_ID)->nullable()->references(CommonConstant::ID)->on(Office::getTableName());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_companies', function (Blueprint $table) {
            //
        });
    }
};
