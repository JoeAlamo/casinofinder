<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LatitudeLongitudeIndexes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('casino_locations', function (Blueprint $table) {
            $table->index('latitude', 'casino_locations_latitude_index');
            $table->index('longitude', 'casino_locations_longitude_index');
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
            $table->dropIndex(['casino_locations_latitude_index', 'casino_locations_longitude_index']);
        });
    }
}
