<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClmnInTariffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tariffs', function (Blueprint $table) {
            $table->string('irrevocable')->nullable();
            $table->integer('prepayment')->nullable();
            $table->integer('hour')->nullable();
            $table->integer('fine')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tariffs', function (Blueprint $table) {
            $table->dropColumn('irrevocable');
            $table->dropColumn('prepayment');
            $table->dropColumn('hour');
            $table->dropColumn('fine');
        });
    }
}
