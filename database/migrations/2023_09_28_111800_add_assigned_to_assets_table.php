<?php

use App\Domains\Constant\AssetConstant;
use App\Domains\Constant\CommonConstant;
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
        Schema::table('assets', function (Blueprint $table) {
            $table->foreignUuid(AssetConstant::ASSIGNED_TO)->nullable()->references(CommonConstant::ID)->on(User::getTableName());
            $table->dateTime(AssetConstant::ASSIGNED_DATE)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            //
        });
    }
};
