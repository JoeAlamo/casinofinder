<?php

use Illuminate\Database\Seeder;
use CasinoFinder\Models\Casino;
use CasinoFinder\Models\CasinoOpeningTime;

class CasinoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // FK constraints will cascade deletion to locations + openingtimes
        DB::table('casinos')->delete();

        $casinos =
            array (
                0 =>
                    array (
                        'casino' =>
                            array (
                                'name' => 'Grosvenor Casino Sheffield',
                                'description' => 'Grosvenor Casino Sheffield is more than just a Casino, it\'s the perfect day and night leisure destination with a fantastic restaurant, amazing bar, sports & entertainment lounge, great poker, conference room and much, much more.',
                            ),
                        'casino_location' =>
                            array (
                                'address' => '87 Duchess Rd',
                                'city' => 'Sheffield',
                                'postal_code' => 'S2 4BG',
                                'latitude' => 53.372635000000002,
                                'longitude' => -1.462604,
                                'google_maps_place_id' => 'ChIJY8e7zpqCeUgRHKnpLk_OdrU',
                            ),
                        'casino_opening_times' =>
                            array (
                                0 =>
                                    array (
                                        'day' => 0,
                                        'open_time' => '08:30:00',
                                        'close_time' => '22:00:00',
                                    ),
                                1 =>
                                    array (
                                        'day' => 1,
                                        'open_time' => '08:30:00',
                                        'close_time' => '22:00:00',
                                    ),
                                2 =>
                                    array (
                                        'day' => 2,
                                        'open_time' => '08:30:00',
                                        'close_time' => '22:00:00',
                                    ),
                                3 =>
                                    array (
                                        'day' => 3,
                                        'open_time' => '08:30:00',
                                        'close_time' => '22:00:00',
                                    ),
                                4 =>
                                    array (
                                        'day' => 4,
                                        'open_time' => '08:30:00',
                                        'close_time' => '22:00:00',
                                    ),
                            ),
                    ),
                1 =>
                    array (
                        'casino' =>
                            array (
                                'name' => 'Stardust Casino Slots',
                                'description' => '',
                            ),
                        'casino_location' =>
                            array (
                                'address' => '235 High St',
                                'city' => 'City Centre',
                                'postal_code' => 'SA1 1NZ',
                                'latitude' => 51.622278999999999,
                                'longitude' => -3.9421339999999998,
                                'google_maps_place_id' => 'ChIJyWbxIkr1bkgRSERuoEYAxkg',
                            ),
                        'casino_opening_times' =>
                            array (
                            ),
                    ),
                2 =>
                    array (
                        'casino' =>
                            array (
                                'name' => 'Empire Casino',
                                'description' => 'A stunning Vegas-style casino in London\'s Leicester Square. Play classic games, enjoy a cocktail in our bars & indulge at our Asian restaurant.',
                            ),
                        'casino_location' =>
                            array (
                                'address' => '5-6 Leicester Square',
                                'city' => 'London',
                                'postal_code' => 'WC2H 7NA',
                                'latitude' => 51.510866999999998,
                                'longitude' => -0.13034399999999999,
                                'google_maps_place_id' => 'ChIJU0_GCNIEdkgRFFmOhiqR4Ts',
                            ),
                        'casino_opening_times' =>
                            array (
                                0 =>
                                    array (
                                        'day' => 0,
                                        'open_time' => '10:00:00',
                                        'close_time' => '12:00:00',
                                    ),
                                1 =>
                                    array (
                                        'day' => 0,
                                        'open_time' => '18:00:00',
                                        'close_time' => '23:30:00',
                                    ),
                                2 =>
                                    array (
                                        'day' => 1,
                                        'open_time' => '11:00:00',
                                        'close_time' => '23:59:59',
                                    ),
                                3 =>
                                    array (
                                        'day' => 2,
                                        'open_time' => '00:00:00',
                                        'close_time' => '05:00:00',
                                    ),
                                4 =>
                                    array (
                                        'day' => 5,
                                        'open_time' => '05:30:00',
                                        'close_time' => '17:00:00',
                                    ),
                            ),
                    ),
                3 =>
                    array (
                        'casino' =>
                            array (
                                'name' => 'Grosvenor Casino Plymouth',
                                'description' => 'Modern chain casino with gaming tables and slot machines, a grill restaurant and a late bar.',
                            ),
                        'casino_location' =>
                            array (
                                'address' => '15 Derry\'s Cross',
                                'city' => 'Plymouth',
                                'postal_code' => 'PL1 2SW',
                                'latitude' => 50.36965,
                                'longitude' => -4.1464840000000001,
                                'google_maps_place_id' => 'ChIJmaccUE6TbEgRo5BdDW4U5Fw',
                            ),
                        'casino_opening_times' =>
                            array (
                                0 =>
                                    array (
                                        'day' => 0,
                                        'open_time' => '15:30:00',
                                        'close_time' => '23:00:00',
                                    ),
                                1 =>
                                    array (
                                        'day' => 2,
                                        'open_time' => '01:00:00',
                                        'close_time' => '07:00:00',
                                    ),
                                2 =>
                                    array (
                                        'day' => 4,
                                        'open_time' => '16:30:00',
                                        'close_time' => '23:59:59',
                                    ),
                                3 =>
                                    array (
                                        'day' => 5,
                                        'open_time' => '00:00:00',
                                        'close_time' => '04:00:00',
                                    ),
                            ),
                    ),
                4 =>
                    array (
                        'casino' =>
                            array (
                                'name' => 'Genting Casino Leicester',
                                'description' => 'Branch of a casino chain offering table games & slots, plus a late bar serving snacks & sandwiches.',
                            ),
                        'casino_location' =>
                            array (
                                'address' => '17-19 East Bond Street',
                                'city' => 'Leicester',
                                'postal_code' => 'LE1 4SU',
                                'latitude' => 52.637255000000003,
                                'longitude' => -1.135092,
                                'google_maps_place_id' => 'ChIJKdhEFB5hd0gROL2fegNt5aY',
                            ),
                        'casino_opening_times' =>
                            array (
                                0 =>
                                    array (
                                        'day' => 0,
                                        'open_time' => '11:00:00',
                                        'close_time' => '23:59:59',
                                    ),
                                1 =>
                                    array (
                                        'day' => 1,
                                        'open_time' => '00:00:00',
                                        'close_time' => '06:00:00',
                                    ),
                                2 =>
                                    array (
                                        'day' => 1,
                                        'open_time' => '11:00:00',
                                        'close_time' => '23:59:59',
                                    ),
                                3 =>
                                    array (
                                        'day' => 2,
                                        'open_time' => '00:00:00',
                                        'close_time' => '06:00:00',
                                    ),
                            ),
                    ),
                5 =>
                    array (
                        'casino' =>
                            array (
                                'name' => 'Aspers Casino Newcastle',
                                'description' => 'A truly fine establishment.',
                            ),
                        'casino_location' =>
                            array (
                                'address' => 'Newgate St',
                                'city' => 'Newcastle upon Tyne',
                                'postal_code' => 'NE1 5TG',
                                'latitude' => 54.972662,
                                'longitude' => -1.6195539999999999,
                                'google_maps_place_id' => 'ChIJP9n_rspwfkgRLhl8CzvBbLU',
                            ),
                        'casino_opening_times' =>
                            array (
                                0 =>
                                    array (
                                        'day' => 0,
                                        'open_time' => '00:00:00',
                                        'close_time' => '03:00:00',
                                    ),
                                1 =>
                                    array (
                                        'day' => 4,
                                        'open_time' => '17:00:00',
                                        'close_time' => '23:59:59',
                                    ),
                                2 =>
                                    array (
                                        'day' => 5,
                                        'open_time' => '00:00:00',
                                        'close_time' => '03:00:00',
                                    ),
                                3 =>
                                    array (
                                        'day' => 5,
                                        'open_time' => '17:00:00',
                                        'close_time' => '23:59:59',
                                    ),
                                4 =>
                                    array (
                                        'day' => 6,
                                        'open_time' => '00:00:00',
                                        'close_time' => '03:00:00',
                                    ),
                                5 =>
                                    array (
                                        'day' => 6,
                                        'open_time' => '17:00:00',
                                        'close_time' => '23:59:59',
                                    ),
                            ),
                    ),
                6 =>
                    array (
                        'casino' =>
                            array (
                                'name' => 'Victory Amusements',
                                'description' => 'Victory Amusements are a small chain of casinos based mainly in North England',
                            ),
                        'casino_location' =>
                            array (
                                'address' => '36-38 Botchergate',
                                'city' => 'Carlisle',
                                'postal_code' => 'CA1 1QS',
                                'latitude' => 54.890931999999999,
                                'longitude' => -2.9316550000000001,
                                'google_maps_place_id' => 'ChIJ1fpWCC8afUgRYiuVEp4D2H0',
                            ),
                        'casino_opening_times' =>
                            array (
                                0 =>
                                    array (
                                        'day' => 0,
                                        'open_time' => '09:00:00',
                                        'close_time' => '22:00:00',
                                    ),
                                1 =>
                                    array (
                                        'day' => 3,
                                        'open_time' => '11:00:00',
                                        'close_time' => '22:30:00',
                                    ),
                                2 =>
                                    array (
                                        'day' => 5,
                                        'open_time' => '05:00:00',
                                        'close_time' => '20:00:00',
                                    ),
                                3 =>
                                    array (
                                        'day' => 5,
                                        'open_time' => '21:00:00',
                                        'close_time' => '23:30:00',
                                    ),
                            ),
                    ),
                7 =>
                    array (
                        'casino' =>
                            array (
                                'name' => 'Alea Glasgow Casino',
                                'description' => 'Casino, trendy bars, restaurant with private room, function spaces and live sport on plasma screen.',
                            ),
                        'casino_location' =>
                            array (
                                'address' => 'Springfield Quay, Paisley Rd',
                                'city' => 'Glasgow',
                                'postal_code' => 'G5 8NP',
                                'latitude' => 55.855082000000003,
                                'longitude' => -4.274718,
                                'google_maps_place_id' => 'ChIJRTELx4ZGiEgRzAV_-5bMcBc',
                            ),
                        'casino_opening_times' =>
                            array (
                                0 =>
                                    array (
                                        'day' => 0,
                                        'open_time' => '15:00:00',
                                        'close_time' => '23:59:59',
                                    ),
                                1 =>
                                    array (
                                        'day' => 1,
                                        'open_time' => '00:00:00',
                                        'close_time' => '05:30:00',
                                    ),
                                2 =>
                                    array (
                                        'day' => 1,
                                        'open_time' => '15:00:00',
                                        'close_time' => '23:59:59',
                                    ),
                                3 =>
                                    array (
                                        'day' => 2,
                                        'open_time' => '00:00:00',
                                        'close_time' => '05:30:00',
                                    ),
                                4 =>
                                    array (
                                        'day' => 5,
                                        'open_time' => '07:30:00',
                                        'close_time' => '23:00:00',
                                    ),
                            ),
                    ),
            );


        foreach ($casinos as $casinoRaw) {
            $casino = Casino::create($casinoRaw['casino']);
            $casino->casinoLocation()->create($casinoRaw['casino_location']);
            $casino->casinoOpeningTimes()->saveMany(
                array_map(function($openingTime) {
                    return new CasinoOpeningTime([
                        'day' => $openingTime['day'],
                        'open_time' => $openingTime['open_time'],
                        'close_time' => $openingTime['close_time']
                    ]);
                }, $casinoRaw['casino_opening_times'])
            );
        }
    }
}
