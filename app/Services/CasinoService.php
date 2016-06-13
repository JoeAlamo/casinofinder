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
        }])->get();
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
    public function findNearestCasino($latitude, $longitude, $radius = 200)
    {
        $distanceUnit = 69.0; // Miles. Consider altering method so this can be specified
        // Query cannot be parameterised due to structure (anonymous join, using placeholders as identifiers)
        // So cast all values to numeric form to defend against SQLi
        $latitude = (float)$latitude;
        $longitude = (float)$longitude;
        $radius = (int)$radius;

        // Fast implementation of Vincenty formula - http://www.plumislandmedia.net/mysql/vicenty-great-circle-distance-formula/
        // Vincenty over Haversine due to stability with close distances to nearby casinos
        $nearestCasino = \DB::select("
            SELECT casino_id, distance FROM (
                SELECT c.casino_id,
                       c.latitude,
                       c.longitude,
                       p.radius,
                       p.distance_unit * vincenty(c.latitude, c.longitude, latpoint, longpoint) AS distance
                FROM casino_locations AS c
                JOIN (
                  SELECT  $latitude  AS latpoint,
                          $longitude AS longpoint,
                          $radius AS radius,
                          $distanceUnit AS distance_unit
                ) AS p
                WHERE c.latitude 
                    BETWEEN p.latpoint - (p.radius / p.distance_unit)
                        AND p.latpoint + (p.radius / p.distance_unit)
                AND c.longitude
                    BETWEEN p.longpoint - (p.radius / (p.distance_unit * COS(RADIANS(p.latpoint))))
                        AND p.longpoint + (p.radius / (p.distance_unit * COS(RADIANS(p.latpoint))))
            ) AS d
            WHERE distance <= radius
            ORDER BY distance
            LIMIT 1
        ");

        return empty($nearestCasino) ? false : $nearestCasino[0];
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