<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('number', 40)->unique();
            $table->string('mail', 255)->nullable();
            $table->string('serial', 255)->nullable();
            $table->string('passport_number', 255)->nullable();
            $table->string('passport_data', 255)->nullable();
            $table->text('comments_about_client')->nullable();
            $table->integer('number_of_sessions')->default(1);

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
        Schema::dropIfExists('clients');
    }
}
