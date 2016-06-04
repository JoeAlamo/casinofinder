<?php

namespace CasinoFinder\Http\Controllers\Admin;

use CasinoFinder\Models\Casino;
use CasinoFinder\Models\CasinoOpeningTime;
use CasinoFinder\Validation\CasinoFormValidator;
use Illuminate\Http\Request;

use CasinoFinder\Http\Requests;
use CasinoFinder\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class AdminCasinoController extends Controller
{
    public function __construct() {

    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $casinos = Casino::all();

        return \View::make('admin.casino.index', compact('casinos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return \View::make('admin.casino.create')
                    ->nest('casinoForm', 'admin.casino.casinoForm');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param CasinoFormValidator $casinoValidator
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CasinoFormValidator $casinoValidator)
    {
        try {
            $casinoValidator->validate($request->all());
            $casino = Casino::create($request->only(['name', 'description']));
            $casino->casinoLocation()->create(
                $request->only(['address', 'city', 'postal_code', 'latitude', 'longitude', 'google_maps_place_id'])
            );
            $casino->casinoOpeningTimes()->saveMany(
                array_map(function($openingTime) {
                    return new CasinoOpeningTime([
                        'day' => $openingTime['day'],
                        'open_time' => $openingTime['open_time'],
                        'close_time' => $openingTime['close_time']
                    ]);
                }, $request->input('opening_time', []))
            );

            return $this->show($casino);
        } catch (ValidationException $e) {
            return \Redirect::back()
                ->withInput($request->except(['_token']))
                ->withErrors($e->validator->errors());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Casino $casino
     * @return \Illuminate\Http\Response
     */
    public function show(Casino $casino)
    {
        return $casino->load(['casinoLocation', 'casinoOpeningTimes']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Casino $casino
     * @return \Illuminate\Http\Response
     */
    public function edit(Casino $casino)
    {
        $casino->load(['casinoLocation', 'casinoOpeningTimes']);

        // Format casino data so it can bind to the form
        $formattedCasino = array_merge($casino->casinoLocation->getOriginal(), $casino->getOriginal());
        $formattedCasino['opening_time'] = $casino->casinoOpeningTimes->map(function ($model) {
            return $model->getOriginal();
        })->all();

        return \View::make('admin.casino.edit', ['casino' => (object)$formattedCasino])
            ->nest('casinoForm', 'admin.casino.casinoForm', ['casino' => (object)$formattedCasino]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Casino $casino
     * @param CasinoFormValidator $casinoValidator
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Casino $casino, CasinoFormValidator $casinoValidator)
    {
        try {
            $casinoValidator->validate($request->all());
            $casino->update($request->only(['name', 'description']));
            $casino->casinoLocation()->update(
                $request->only(['address', 'city', 'postal_code', 'latitude', 'longitude', 'google_maps_place_id'])
            );
            $casino->casinoOpeningTimes()->delete();
            $casino->casinoOpeningTimes()->saveMany(
                array_map(function($openingTime) {
                    return new CasinoOpeningTime([
                        'day' => $openingTime['day'],
                        'open_time' => $openingTime['open_time'],
                        'close_time' => $openingTime['close_time']
                    ]);
                }, $request->input('opening_time', []))
            );

            return $this->show($casino);
        } catch (ValidationException $e) {
            return \Redirect::back()
                ->withInput($request->except(['_token']))
                ->withErrors($e->validator->errors());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Casino $casino
     * @return \Illuminate\Http\Response
     */
    public function destroy(Casino $casino)
    {
        // FK constraints will cascade and delete casino location + opening times
        try {
            $casino->delete();
            return \Response::json('Casino deleted successfully!');
        } catch (\Exception $e) {
            return \Response::json('Error deleting casino', 500);
        }
    }
}
