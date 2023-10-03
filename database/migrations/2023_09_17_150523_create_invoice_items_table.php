<?php

use App\Domains\Constant\CommonConstant;
use App\Domains\Constant\InvoiceItemConstant;
use App\Domains\Enum\Invoice\InvoiceItemTypeEnum;
use App\Models\Feature;
use App\Models\Invoice;
use App\Models\Plan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('Invoice_items', function (Blueprint $table) {
            $table->uuid(InvoiceItemConstant::ID)->unique()->primary();
            $table->foreignUuid(InvoiceItemConstant::INVOICE_ID)->references(CommonConstant::ID)->on(Invoice::getTableName());
            $table->foreignUuid(InvoiceItemConstant::PLAN_ID)->nullable()->references(CommonConstant::ID)->on(Plan::getTableName());
            $table->foreignUuid(InvoiceItemConstant::FEATURE_ID)->nullable()->references(CommonConstant::ID)->on(Feature::getTableName());
            $table->integer(InvoiceItemConstant::QUANTITY)->unique();
            $table->decimal(InvoiceItemConstant::AMOUNT);
            $table->enum(InvoiceItemConstant::TYPE, InvoiceItemTypeEnum::values());
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Invoice_items');
    }
};
