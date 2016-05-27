<?php

namespace CasinoFinder\Http\Controllers\Admin;

use CasinoFinder\Http\Controllers\Controller;
use CasinoFinder\Http\Requests;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin');
    }
}
