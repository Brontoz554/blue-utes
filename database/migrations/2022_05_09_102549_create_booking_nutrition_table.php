<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingNutritionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_nutrition', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');

            $table->string('date');
            $table->integer('breakfast')->nullable();
            $table->integer('dinner')->nullable();
            $table->integer('lunch')->nullable();
            $table->timestamps();

            $table->foreign('booking_id')
                ->references('id')->on('booking_rooms')
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
        Schema::dropIfExists('booking_nutrition');
    }
}
