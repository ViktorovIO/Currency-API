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
        Schema::create('currencies', function (Blueprint $table) {
            $table->string('code', 3)->comment('Числовой код валюты (944)');
            $table->string('char_code', 3)->comment('Символьный код валюты (RUB)')->unique();
            $table->string('name_single')->comment('Название для единицы валюты (один рубль)');
            $table->string('name_many')->comment('Название для нескольких единиц валюты (десять рублей)');
            $table->timestamps();

            $table->primary('code');
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
