<?php

namespace CasinoFinder\Http\Controllers\Admin;

use CasinoFinder\Models\Casino;
use Illuminate\Http\Request;

use CasinoFinder\Http\Requests;
use CasinoFinder\Http\Controllers\Controller;

class AdminCasinoController extends Controller
{
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
        return \View::make('admin.casino.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  Casino $casino
     * @return \Illuminate\Http\Response
     */
    public function show(Casino $casino)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Casino $casino
     * @return \Illuminate\Http\Response
     */
    public function edit(Casino $casino)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Casino $casino
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Casino $casino)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Casino $casino
     * @return \Illuminate\Http\Response
     */
    public function destroy(Casino $casino)
    {
        //
    }
}
