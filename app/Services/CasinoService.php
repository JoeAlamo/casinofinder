<?php
/**
 * Created by PhpStorm.
 * User: Joe Alamo
 * Date: 09/06/2016
 * Time: 18:46
 */

namespace CasinoFinder\Services;

use Illuminate\Support\Arr;
use CasinoFinder\Models\Casino;
use CasinoFinder\Models\CasinoOpeningTime;

class CasinoService implements CasinoServiceInterface
{

    /**
     * @inheritDoc
     */
    public function getAllCasinos($childRelations = false)
    {
        if (!$childRelations) {
            return Casino::all();
        }

        return Casino::with(['casinoLocation', 'casinoOpeningTimes' => function($query) {
            $query->orderBy('day');
        }])->all();
    }

    /**
     * @inheritDoc
     */
    public function getCasino($id, $childRelations = false)
    {
        if (!$childRelations) {
            return Casino::findOrFail($id);
        }

        return Casino::with(['casinoLocation', 'casinoOpeningTimes' => function($query) {
            $query->orderBy('day');
        }])->findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function findNearestCasino($latitude, $longitude, $radius = 100)
    {
        $distanceUnit = 69.0; // Miles. Consider altering method so this can be specified

        // Fast implementation of haversine equation - http://www.plumislandmedia.net/mysql/haversine-mysql-nearest-loc/
        $nearestCasino =  \DB::select(
            'SELECT id FROM 
                (
                    SELECT c.casino_id,
                           c.latitude,
                           c.longitude,
                           p.radius,
                           p.distance_unit
                              * DEGREES(ACOS(COS(RADIANS(p.latpoint))
                              * COS(RADIANS(c.latitude))
                              * COS(RADIANS(p.longpoint - c.longitude))
                              + SIN(RADIANS(p.latpoint))
                              * SIN(RADIANS(c.latitude)))) AS distance
                    FROM casino_locations AS c
                    JOIN (
                        SELECT :latitude AS latpoint,
                               :longitude AS longpoint,
                               :radius AS radius,
                               :distanceUnit AS distance_unit
                    ) AS p ON 1=1
                    WHERE c.latitude 
                        BETWEEN p.latpoint - (p.radius / p.distance_unit) 
                            AND p.latpoint + (p.radius / p.distance_unit)
                    AND c.longitude 
                        BETWEEN p.longpoint - (p.radius / (p.distance_unit * COS(RADIANS(p.latpoint))))
                            AND p.longpoint + (p.radius / (p.distance_unit * COS(RADIANS(p.latpoint))))
                ) AS d
            WHERE distance <= radius
            LIMIT 1',
            [
                'latitude' => $latitude,
                'longitude' => $longitude,
                'radius' => $radius,
                'distanceUnit' => $distanceUnit,
            ]
        );

        return empty($nearestCasino) ? false : $nearestCasino[0]->id;
    }

    /**
     * @inheritDoc
     */
    public function createNewCasino(array $input)
    {
        $casino = Casino::create(Arr::only($input, ['name', 'description']));
        $casino->casinoLocation()->create(
            Arr::only($input, ['address', 'city', 'postal_code', 'latitude', 'longitude', 'google_maps_place_id'])
        );
        $casino->casinoOpeningTimes()->saveMany(
            array_map(function($openingTime) {
                return new CasinoOpeningTime([
                    'day' => $openingTime['day'],
                    'open_time' => $openingTime['open_time'],
                    'close_time' => $openingTime['close_time']
                ]);
            }, Arr::get($input, 'opening_time', []))
        );

        return $casino;
    }

    /**
     * @inheritDoc
     */
    public function updateCasino($id, array $input)
    {
        $casino = $this->getCasino($id);
        $casino->update(Arr::only($input, ['name', 'description']));
        $casino->casinoLocation()->update(
            Arr::only($input, ['address', 'city', 'postal_code', 'latitude', 'longitude', 'google_maps_place_id'])
        );
        $casino->casinoOpeningTimes()->delete();
        $casino->casinoOpeningTimes()->saveMany(
            array_map(function($openingTime) {
                return new CasinoOpeningTime([
                    'day' => $openingTime['day'],
                    'open_time' => $openingTime['open_time'],
                    'close_time' => $openingTime['close_time']
                ]);
            }, Arr::get($input, 'opening_time', []))
        );

        return $casino;
    }

    /**
     * @inheritDoc
     */
    public function deleteCasino($id)
    {
        // FK constraints will cascade and delete casino location + opening times
        return Casino::destroy($id) > 0;
    }
}