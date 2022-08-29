<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency_values', function (Blueprint $table) {
            $table->id();
            $table->string('code', 3)->comment('Числовой код валюты (944)');
            $table->date('date')->comment('Дата значения');
            $table->double('value', 8, 4)->comment('Значение (стоимость) на текущую дату');
            $table->integer('nominal')->comment('Номинал валюты по отношению к рублю');
            $table->timestamps();

            $table->unique(['code', 'date'], 'code_date_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currency_values');
    }
};
