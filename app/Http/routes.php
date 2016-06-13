<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('casinofinder');
});

Route::auth();

Route::any('/register', function () {
    return Response::redirectTo('/');
});

Route::get('/admin', 'Admin\AdminController@index')
    ->middleware('auth');

Route::group(['middleware' => 'auth', 'namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::resource('casino', 'AdminCasinoController');
});

Route::group(['as' => 'casinoFinder.', 'namespace' => 'CasinoFinder', 'prefix' => 'casinoFinder'], function () {
    Route::get('getAllCasinos', 'CasinoFinderController@getAllCasinos')
        ->name('getAllCasinos');

    Route::get('findNearestCasino', 'CasinoFinderController@findNearestCasino')
        ->name('findNearestCasino');
});
