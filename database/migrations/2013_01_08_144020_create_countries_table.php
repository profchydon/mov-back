<?php

use App\Domains\Constant\CommonConstant;
use App\Domains\Enum\Plan\PlanProcessorNameEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->bigIncrements(CommonConstant::ID)->unique();
            $table->string(CommonConstant::NAME)->unique();
            $table->string(CommonConstant::CODE)->unique();
            $table->json(CommonConstant::STATES);
            $table->string(CommonConstant::CURRENY_CODE)->default('USD');
            $table->enum(CommonConstant::PAYMENT_PROCESSOR, PlanProcessorNameEnum::values())->default(PlanProcessorNameEnum::FLUTTERWAVE->value);
            $table->string(CommonConstant::STATUS)->default(CommonConstant::INACTIVE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
};
