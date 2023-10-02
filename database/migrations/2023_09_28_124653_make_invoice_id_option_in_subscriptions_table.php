<?php

use App\Domains\Constant\CommonConstant;
use App\Domains\Constant\SubscriptionConstant;
use App\Models\Invoice;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->string(SubscriptionConstant::INVOICE_ID)->references(CommonConstant::ID)->on(Invoice::getTableName())->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->string(SubscriptionConstant::INVOICE_ID)->references(CommonConstant::ID)->on(Invoice::getTableName());
        });
    }
};
