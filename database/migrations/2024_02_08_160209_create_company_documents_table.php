<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\Constant\DocumentConstant;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->uuid(DocumentConstant::ID)->primary();
            $table->string(DocumentConstant::NAME);
            $table->string(DocumentConstant::TYPE);
            $table->foreignUuid(DocumentConstant::COMPANY_ID)->constrained(\App\Models\Company::getTableName());
            $table->foreignUuid(DocumentConstant::USER_ID)->constrained(\App\Models\User::getTableName());
            $table->date(DocumentConstant::REGISTRATION_DATE)->nullable();
            $table->date(DocumentConstant::EXPIRATION_DATE)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_documents');
    }
};
