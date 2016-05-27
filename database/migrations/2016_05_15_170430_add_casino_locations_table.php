<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCasinoLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('casino_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('address');
            $table->string('city');
            $table->string('postal_code');
            $table->float('latitude', 10, 6);
            $table->float('longitude', 10, 6);
            $table->unsignedInteger('casino_id');
            $table->timestamps();

            $table->foreign('casino_id')
                ->references('id')->on('casinos')
                ->onDelete('cascade');
            $table->index(['latitude', 'longitude']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('casino_locations');
    }
}
