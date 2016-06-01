<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPlaceId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('casino_locations', function (Blueprint $table) {
            $table->string('google_maps_place_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('casino_locations', function (Blueprint $table) {
            $table->dropColumn('google_maps_place_id');
        });
    }
}
