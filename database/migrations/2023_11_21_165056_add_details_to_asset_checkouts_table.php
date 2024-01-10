<?php

use App\Domains\Constant\Asset\AssetCheckoutConstant;
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
        Schema::table('asset_checkouts', function (Blueprint $table) {
            $table->string(AssetCheckoutConstant::RETURN_NOTE)->nullable();
            $table->dateTime(AssetCheckoutConstant::DATE_RETURNED)->nullable();
            $table->foreignUuid(AssetCheckoutConstant::RETURN_BY)->nullable()->references(AssetCheckoutConstant::ID)->on(User::getTableName());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asset_checkouts', function (Blueprint $table) {
            //
        });
    }
};
