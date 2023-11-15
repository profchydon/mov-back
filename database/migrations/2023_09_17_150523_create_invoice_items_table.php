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
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->uuid(InvoiceItemConstant::ID)->unique()->primary();
            $table->foreignUuid(InvoiceItemConstant::INVOICE_ID)->references(CommonConstant::ID)->on(Invoice::getTableName());
            $table->uuidMorphs(InvoiceItemConstant::ITEM);
            $table->integer(InvoiceItemConstant::QUANTITY);
            $table->decimal(InvoiceItemConstant::AMOUNT);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
