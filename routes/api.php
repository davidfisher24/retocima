<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});




Route::group(['middleware' => 'api'], function() {
    Route::get('cimero/profile/{id}', 'CimeroController@profileAction');
    Route::get('cimero/logros/{id}', 'CimeroController@allLogrosAction');
    Route::get('cimero/completions/{id}', 'CimeroController@completedAreasAction');
    Route::get('cimas/{id}', 'CimaController@allInProviceAction');
    Route::get('cimas', 'CimaController@allAction');
    Route::get('cima/{id}', 'CimaController@OneAction');
    Route::get('cimas/search/{query}', 'CimaController@searchAction');
    Route::get('patanegra', 'CimaController@pataNegraAction');
    Route::get('patanegraranking', 'CimeroController@rankByPataNegraAction');
    Route::get('communidads', 'CommunidadController@allAction');
    Route::get('provincias/{communidadId}', 'ProvinciaController@communidadAction');
    Route::get('provincias', 'ProvinciaController@allAction');
    Route::get('paises', 'PaisController@allAction');
    Route::get('ranking', 'CimeroController@rankAction');
    Route::get('cimasranking', 'CimaController@rankAction');
    Route::get('provinciasranking', 'ProvinciaController@rankAction');
    Route::get('communidadsranking', 'CommunidadController@rankAction');
    Route::get('filtersranking/{filter}/{id}', 'CimeroController@rankByAreaAction');
    Route::get('provinciasstarted', 'CimeroController@rankByProvincesStartedAction');

});


