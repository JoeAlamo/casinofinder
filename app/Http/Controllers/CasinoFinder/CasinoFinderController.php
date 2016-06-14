<?php
/**
 * Created by PhpStorm.
 * User: Joe Alamo
 * Date: 09/06/2016
 * Time: 17:17
 */

namespace CasinoFinder\Http\Controllers\CasinoFinder;


use Carbon\Carbon;
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

    public function __construct(CasinoServiceInterface $casinoService)
    {
        $this->casinoService = $casinoService;
    }

    /**
     * Retrieve all of the casinos (with relations), format the opening times and return as JSON
     *
     * @return static Converted to JSON automatically
     */
    public function getAllCasinos()
    {
        $casinos = $this->casinoService->getAllCasinos(true)->keyBy('id');
        $casinos->map(function($casino) {
            $casino->formattedCasinoOpeningTimes->map(function($openingTime) {
                $openingTime->open_time = Carbon::createFromFormat('H:i:s', $openingTime->open_time)->format('H:i a');
                $openingTime->close_time = Carbon::createFromFormat('H:i:s', $openingTime->close_time)->format('H:i a');
            });
        });

        return $casinos;
    }

    /**
     * Find the nearest casino based on lat/lng and cache the result
     *
     * @param Request $request
     * @param CasinoFinderValidator $casinoFinderValidator
     * @return \Illuminate\Http\JsonResponse
     */
    public function findNearestCasino(Request $request, CasinoFinderValidator $casinoFinderValidator)
    {
        try {
            $casinoFinderValidator->validate($request->only(['latitude', 'longitude']));

            $nearestCasino = \Cache::remember("nearest_casino_{$request->get('latitude')}_{$request->get('longitude')}", 60, function () use ($request) {
                return $this->casinoService->findNearestCasino($request->get('latitude'), $request->get('longitude'));
            });


            if ($nearestCasino !== false) {
                return \Response::json([
                    'found' => true,
                    'id' => $nearestCasino->casino_id,
                    'distance' => round($nearestCasino->distance, 2),
                ]);
            }

            return \Response::json(['found' => false]);
        } catch (ValidationException $e) {
            return \Response::json(['found' => false]);
        }
    }
}