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
            $table->integer('code')->comment('Числовой код валюты (944)');
            $table->date('date')->comment('Дата значения');
            $table->double('value', 8, 4)->comment('Значение (стоимость) на текущую дату');
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
