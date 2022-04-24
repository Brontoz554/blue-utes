<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTariffTreatmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tariff_treatment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tariff_id');
            $table->unsignedBigInteger('treatment_id');

            $table->foreign('tariff_id')->references('id')->on('tariffs')->onDelete('cascade');
            $table->foreign('treatment_id')->references('id')->on('treatments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tariff_treatment');
    }
}
