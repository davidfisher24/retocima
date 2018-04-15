<?php

use Illuminate\Http\Request;


use App\Http\Controllers\Controller;
use App\Http\Requests;

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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/




Route::group(['middleware' => ['api','cors']], function() {
    Route::get('discover', 'CimaController@discoverAction');

    Route::get('cimero/{id}', 'CimeroController@oneAction');
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

    Route::get('maplines/{id}', function($id){
        if (File::exists(public_path() . '/maplines/'.$id.'.txt')) return File::get(public_path() . '/maplines/'.$id.'.txt');
        else return App\Cima::find($id)->toJson();
    });


    Route::options('auth/login','AuthController@login');
    Route::options('auth/register','AuthController@register');
    Route::options('auth/refresh','AuthController@refresh');
    
    Route::post('auth/register','AuthController@register');
    Route::post('auth/login','AuthController@login');
    Route::get('auth/refresh','AuthController@refresh');
    
    Route::group(['middleware' => 'jwt-auth'], function () {

        Route::options('verify' ,'AuthController@verify');
        Route::get('verify', 'AuthController@verify');

        Route::options('cimero','AuthController@profileAction');
        Route::options('cimero-logros/{provincia}','AuthController@logrosProvinciaAction');
        Route::options('update-logro','AuthController@updateLogroAction');
        Route::options('edit-account','AuthController@updateAccountAction');
        
        Route::get('cimero','AuthController@profileAction');
        Route::get('cimero-logros/{provincia}','AuthController@logrosProvinciaAction');
        Route::post('update-logro','AuthController@updateLogroAction');
        Route::post('edit-account','AuthController@updateAccountAction');
    });


});


