<?php

use App\Domains\Constant\InvoiceConstant;
use App\Domains\Enum\Invoice\InvoiceStatusEnum;
use App\Models\Company;
use App\Models\Currency;
use App\Models\Tenant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->uuid(InvoiceConstant::ID)->unique()->primary();
            $table->foreignUuid(InvoiceConstant::TENANT_ID)->references(InvoiceConstant::ID)->on(Tenant::getTableName());
            $table->foreignUuid(InvoiceConstant::COMPANY_ID)->references(InvoiceConstant::ID)->on(Company::getTableName());
            $table->string(InvoiceConstant::INVOICE_NUMBER)->unique();
            $table->dateTime(InvoiceConstant::DUE_AT)->nullable();
            $table->dateTime(InvoiceConstant::PAID_AT)->nullable();
            $table->decimal(InvoiceConstant::SUB_TOTAL);
            $table->decimal(InvoiceConstant::TAX)->default(0.00);
            $table->string(InvoiceConstant::CURRENCY_CODE);
            $table->enum(InvoiceConstant::STATUS, InvoiceStatusEnum::values())->default(InvoiceStatusEnum::PENDING->value);
            $table->uuidMorphs(InvoiceConstant::BILLABLE);
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
