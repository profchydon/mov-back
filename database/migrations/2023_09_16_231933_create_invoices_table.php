<?php

use App\Models\Tenant;
use App\Models\Company;
use App\Models\Currency;
use Illuminate\Support\Facades\Schema;
use App\Domains\Constant\InvoiceConstant;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Domains\Enum\Invoice\InvoiceStatusEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->uuid(InvoiceConstant::ID)->unique()->primary();
            $table->string(InvoiceConstant::TENANT_ID)->references(InvoiceConstant::ID)->on(Tenant::getTableName());
            $table->string(InvoiceConstant::COMPANY_ID)->references(InvoiceConstant::ID)->on(Company::getTableName());
            $table->string(InvoiceConstant::INVOICE_NUMBER)->unique();
            $table->dateTime(InvoiceConstant::DATE_ISSUED)->default(now());
            $table->dateTime(InvoiceConstant::DUE_DATE)->nullable();
            $table->dateTime(InvoiceConstant::PAID_AT)->nullable();
            $table->decimal(InvoiceConstant::SUB_TOTAL);
            $table->decimal(InvoiceConstant::TAX)->default(0.00);
            $table->foreignIdFor(Currency::class, InvoiceConstant::CURRENCY_ID);
            $table->string(InvoiceConstant::TRANSACTION_REF);
            $table->enum(InvoiceConstant::STATUS, InvoiceStatusEnum::values())->default(InvoiceStatusEnum::PENDING->value);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
