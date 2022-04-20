<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTariffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tariffs', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('treatment')->nullable();
            $table->string('nutrition')->nullable();
            $table->string('accommodation')->nullable();
            $table->string('type_of_day');
            $table->string('check_out_start');
            $table->string('check_out_end');
            $table->integer('price');
            $table->json('another');
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
        Schema::dropIfExists('tariffs');
    }
}
