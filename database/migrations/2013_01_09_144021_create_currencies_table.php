<?php

use App\Domains\Constant\CurrencyConstant;
use App\Domains\Enum\Currency\CurrencyStatusEnum;
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
        Schema::create('currencies', function (Blueprint $table) {
            $table->bigIncrements(CurrencyConstant::ID)->unique();
            $table->string(CurrencyConstant::NAME);
            $table->string(CurrencyConstant::CODE)->unique();
            $table->string(CurrencyConstant::SYMBOL);
            $table->enum(CurrencyConstant::STATUS, CurrencyStatusEnum::values())->default(CurrencyStatusEnum::ACTIVE->value);
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
        Schema::dropIfExists('currencies');
    }
};
