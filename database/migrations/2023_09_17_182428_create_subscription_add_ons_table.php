<?php

use App\Models\Tenant;
use App\Models\Company;
use App\Models\Feature;
use App\Models\Subscription;
use Illuminate\Support\Facades\Schema;
use App\Domains\Constant\CommonConstant;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Domains\Constant\SubscriptionAddOnConstant;
use App\Domains\Enum\Subscription\SubscriptionAddOnStatusEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('SubscriptionAddOn_add_ons', function (Blueprint $table) {
            $table->uuid(SubscriptionAddOnConstant::ID)->unique()->primary();
            $table->string(SubscriptionAddOnConstant::TENANT_ID)->references(CommonConstant::ID)->on(Tenant::getTableName());
            $table->string(SubscriptionAddOnConstant::COMPANY_ID)->references(CommonConstant::ID)->on(Company::getTableName());
            $table->string(SubscriptionAddOnConstant::SUBSCRIPTION_ID)->nullable()->references(CommonConstant::ID)->on(Subscription::getTableName());
            $table->string(SubscriptionAddOnConstant::FEATURE_ID)->nullable()->references(CommonConstant::ID)->on(Feature::getTableName());
            $table->dateTime(SubscriptionAddOnConstant::START_DATE);
            $table->dateTime(SubscriptionAddOnConstant::END_DATE);
            $table->enum(SubscriptionAddOnConstant::STATUS, SubscriptionAddOnStatusEnum::values())->default(SubscriptionAddOnStatusEnum::INACTIVE->value);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('SubscriptionAddOn_add_ons');
    }
};
