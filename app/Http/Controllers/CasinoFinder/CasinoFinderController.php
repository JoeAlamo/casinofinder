<?php
/**
 * Created by PhpStorm.
 * User: Joe Alamo
 * Date: 09/06/2016
 * Time: 17:17
 */

namespace CasinoFinder\Http\Controllers\CasinoFinder;


use CasinoFinder\Http\Controllers\Controller;
use CasinoFinder\Services\CasinoServiceInterface;
use CasinoFinder\Validation\CasinoFinderValidator;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CasinoFinderController extends Controller
{

    /**
     * @var CasinoServiceInterface
     */
    private $casinoService;

    public function __construct(CasinoServiceInterface $casinoService) {
        $this->casinoService = $casinoService;
    }

    public function getAllCasinos()
    {
        return $this->casinoService->getAllCasinos(true);
    }

    public function findNearestCasino(Request $request, CasinoFinderValidator $casinoFinderValidator)
    {
        try {
            $casinoFinderValidator->validate($request->only(['latitude', 'longitude']));

            $nearestCasino = \Cache::remember("nearest_casino_{$request->get('latitude')}_{$request->get('longitude')}", 60, function () use ($request) {
                return $this->casinoService->findNearestCasino($request->get('latitude'), $request->get('longitude'));
            });


            if ($nearestCasino !== false) {
                return \Response::json(['found' => true, 'id' => $nearestCasino]);
            }

            return \Response::json(['found' => false]);
        } catch (ValidationException $e) {
            return \Response::json(['found' => false]);
        }
    }
}