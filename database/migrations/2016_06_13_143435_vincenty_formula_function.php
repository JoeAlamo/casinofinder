<?php

use Illuminate\Database\Migrations\Migration;

class VincentyFormulaFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            DROP FUNCTION IF EXISTS vincenty;
            CREATE FUNCTION vincenty(
                lat1 FLOAT, lon1 FLOAT,
                lat2 FLOAT, lon2 FLOAT
            ) RETURNS FLOAT
            NO SQL
            DETERMINISTIC
            COMMENT \'Returns the distance in degrees on the
                     Earth between two known points
                     of latitude and longitude
                     using the Vincenty formula
                     from http://en.wikipedia.org/wiki/Great-circle_distance\'
            BEGIN
                RETURN  DEGREES(
                ATAN2(
                  SQRT(
                    POW(COS(RADIANS(lat2))*SIN(RADIANS(lon2-lon1)),2) +
                    POW(COS(RADIANS(lat1))*SIN(RADIANS(lat2)) -
                         (SIN(RADIANS(lat1))*COS(RADIANS(lat2)) *
                          COS(RADIANS(lon2-lon1))) ,2)),
                  SIN(RADIANS(lat1))*SIN(RADIANS(lat2)) +
                  COS(RADIANS(lat1))*COS(RADIANS(lat2))*COS(RADIANS(lon2-lon1))));
            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('
            DROP FUNCTION IF EXISTS vincenty;
        ');
    }
}
