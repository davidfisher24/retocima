<?php

use Illuminate\Http\Request;
use DB;

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
    Route::get('cimas/{id}', 'CimaController@allInProviceAction');
    Route::get('cimas', 'CimaController@allAction');
    Route::get('patanegra', 'CimaController@pataNegraAction');
    Route::get('communidads', 'CommunidadController@allAction');
    Route::get('ranking', 'CimeroController@rankAction');
    Route::get('cimasranking', 'CimaController@rankAction');
    Route::get('provinciasranking', 'ProvinciaController@rankAction');
    Route::get('communidadsranking', 'CommunidadController@rankAction');
    Route::get('filtersranking/{filter}/{id}', 'CimeroController@rankByAreaAction');
    Route::get('provinciasstarted', 'CimeroController@rankByProvincesStartedAction');
});


