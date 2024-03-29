<?php
/**
 * Created by PhpStorm.
 * User: Joe Alamo
 * Date: 09/06/2016
 * Time: 18:36
 */

namespace CasinoFinder\Services;


use CasinoFinder\Models\Casino;

interface CasinoServiceInterface
{

    /**
     * Retrieve all casinos, optionally with their child relations
     *
     * @param bool $childRelations Whether to include child relations (location, opening times)
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllCasinos($childRelations = false);

    /**
     * Retrieve individual casino, optionally with child relations
     *
     * @param int $id
     * @param bool $childRelations
     * @return Casino
     */
    public function getCasino($id, $childRelations = false);

    /**
     * Retrieve nearest casino based on the location, within a set radius
     *
     * @param double $latitude
     * @param double $longitude
     * @param int $radius
     * @return \stdClass|false
     */
    public function findNearestCasino($latitude, $longitude, $radius = 200);

    /**
     * Create a new casino, along with it's location and opening times if included
     *
     * @param array $input
     * @return Casino
     */
    public function createNewCasino(array $input);

    /**
     * Update the given casino with the new $input
     *
     * @param int $id
     * @param array $input
     * @return Casino
     */
    public function updateCasino($id, array $input);

    /**
     * Permanently delete the given casino from storage
     * 
     * @param int $id
     * @return bool
     */
    public function deleteCasino($id);

}