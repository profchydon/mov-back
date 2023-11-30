<?php

use App\Domains\Constant\CommonConstant;
use App\Domains\Constant\UserConstant;
use App\Models\Office;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string(UserConstant::EMPLOYMENT_TYPE)->nullable();
            $table->foreignUuid(UserConstant::OFFICE_ID)->nullable()->references(CommonConstant::ID)->on(Office::getTableName());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('=users', function (Blueprint $table) {
            //
        });
    }
};
