<?php

use App\Domains\Constant\FileConstant;
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
        Schema::create('files', function (Blueprint $table) {
            $table->uuid(FileConstant::ID)->unique()->primary();
            $table->uuid(FileConstant::FILEABLE_ID);
            $table->string(FileConstant::FILEABLE_TYPE);
            $table->string(FileConstant::PATH);
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
