<?php

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
        $enumValues = "'" . \Illuminate\Support\Arr::join(\App\Domains\Enum\Asset\AssetStatusEnum::values(), "','") . "'";

        \Illuminate\Support\Facades\DB::statement("ALTER TABLE assets MODIFY status ENUM({$enumValues})");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
