<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoice_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('company_id')->constrained('companies');
            $table->foreignUuid('invoice_id')->constrained('invoices');
            $table->string('processor')->constrained('payment_processors', 'slug');
            $table->string('payment_link');
            $table->string('tx_ref');
            $table->enum('status', \App\Domains\Enum\PaymentStatusEnum::values())->default(\App\Domains\Enum\PaymentStatusEnum::PROCESSING->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_payments');
    }
};
