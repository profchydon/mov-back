<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\Constant\SubscriptionPaymentConstant;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscription_payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid(SubscriptionPaymentConstant::TENANT_ID)->references(\App\Domains\Constant\CommonConstant::ID)->on(\App\Models\Tenant::getTableName());
            $table->foreignUuid(SubscriptionPaymentConstant::COMPANY_ID)->references(\App\Domains\Constant\CommonConstant::ID)->on(\App\Models\Company::getTableName());
            $table->foreignUuid(SubscriptionPaymentConstant::SUBSCRIPTION_ID)->references(\App\Domains\Constant\CommonConstant::ID)->on(\App\Models\Subscription::getTableName());
            $table->string(SubscriptionPaymentConstant::PAYMENT_LINK);
            $table->enum(SubscriptionPaymentConstant::STATUS, \App\Domains\Enum\PaymentStatusEnum::values())->default(\App\Domains\Enum\PaymentStatusEnum::PROCESSING->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_payments');
    }
};
