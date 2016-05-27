<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCasinoOpeningTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('casino_opening_times', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedSmallInteger('day');
            $table->time('open_time');
            $table->time('close_time');
            $table->unsignedInteger('casino_id');
            $table->timestamps();

            $table->foreign('casino_id')
                ->references('id')->on('casinos')
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
        Schema::drop('casino_opening_times');
    }
}
