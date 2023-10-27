<?php

use App\Domains\Constant\CommonConstant;
use App\Domains\Constant\TaggableConstant;
use App\Models\Tag;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('taggables', function (Blueprint $table) {
            $table->uuid(TaggableConstant::ID)->unique()->primary();
            $table->foreignUuid(TaggableConstant::TAG_ID)->references(CommonConstant::ID)->on(Tag::getTableName());
            $table->string(TaggableConstant::TAGGABLE_TYPE);
            $table->uuid(TaggableConstant::TAGGABLE_ID);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taggables');
    }
};
