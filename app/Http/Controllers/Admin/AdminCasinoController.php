<?php

namespace CasinoFinder\Http\Controllers\Admin;

use CasinoFinder\Services\CasinoServiceInterface;
use CasinoFinder\Validation\CasinoFormValidator;
use Illuminate\Http\Request;

use CasinoFinder\Http\Requests;
use CasinoFinder\Http\Controllers\Controller;

class AdminCasinoController extends Controller
{

    /**
     * @var CasinoServiceInterface
     */
    private $casinoService;

    public function __construct(CasinoServiceInterface $casinoService) {
        $this->casinoService = $casinoService;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $casinos = $this->casinoService->getAllCasinos();

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
        $casinoValidator->validate($request->all());
        $casino = $this->casinoService->createNewCasino($request->except(['_token']));

        return \View::make('admin.casino.show', compact('casino'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $casino = $this->casinoService->getCasino($id, true);

        return \View::make('admin.casino.show', compact('casino'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $casino = $this->casinoService->getCasino($id, true);

        // Format casino data so it can bind to the form
        $formattedCasino = array_merge($casino->casinoLocation->getAttributes(), $casino->getAttributes());
        $formattedCasino['opening_time'] = $casino->casinoOpeningTimes->map(function ($model) {
            return $model->getAttributes();
        })->all();

        return \View::make('admin.casino.edit', ['casino' => (object)$formattedCasino])
            ->nest('casinoForm', 'admin.casino.casinoForm', ['casino' => (object)$formattedCasino]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @param CasinoFormValidator $casinoValidator
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, CasinoFormValidator $casinoValidator)
    {
        $casinoValidator->validate($request->all());
        $casino = $this->casinoService->updateCasino($id, $request->except(['_token']));

        return \View::make('admin.casino.show', compact('casino'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$this->casinoService->deleteCasino($id)) {
            return \Response::json('Error deleting casino', 500);
        }

        return \Response::json('Casino deleted successfully!');
    }
}
