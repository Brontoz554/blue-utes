<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTariffRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tariff_rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('room_types_id');
            $table->unsignedBigInteger('tariff_id');

            $table->foreign('room_types_id')
                ->references('id')->on('room_types')
                ->onDelete('cascade');

            $table->foreign('tariff_id')
                ->references('id')->on('tariffs')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tariff_rooms');
    }
}
