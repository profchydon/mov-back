<?php

use App\Domains\Constant\TagConstant;
use App\Models\User;
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
        Schema::table('tags', function (Blueprint $table) {
            $table->foreignUuid(TagConstant::CREATED_BY)->nullable()->after(TagConstant::NAME)->references(TagConstant::ID)->on(User::getTableName());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tags', function (Blueprint $table) {
            //
        });
    }
};
