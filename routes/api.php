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
    Route::get('provincias', function() {
        return App\Provincia::all()->toJSON();
    });

    Route::get('communidads', function() {
        return App\Communidad::all()->toJSON();
    });
 
    Route::get('provincias/{id}', function($id) {
        return App\Provincia::where('communidad_id',$id)->get()->toJSON();
    });
 
    Route::get('cimas/{id}', function($id) {
        return App\Cima::where('provincia_id',$id)->get()->toJSON();
    });

    Route::get('cima/{id}', function($id) {
        return App\Cima::with('vertientes')->find($id)->toJSON();
    });

    Route::get('/ranking/baseranking/', 'Api\ApiTablesController@baseCimeroRanking');
    Route::get('/statistics/cimasbylogro/', 'Api\ApiTablesController@getAllCimasRankedByLogros');
    Route::get('/statistics/cimerosbyprovincesstarted/', 'Api\ApiTablesController@getCimerosWithProvinciasWithAtLeastOneLogro');
    Route::get('/statistics/provincesbylogro/', 'Api\ApiTablesController@getAllProvinciasRankedByLogros');
    Route::get('/statistics/comunidadsbylogro/', 'Api\ApiTablesController@getAllCommunidadsRankedByLogros');
    Route::get('/statistics/cimerosbylogroinzones/{filter}/{id}', 'Api\ApiTablesController@getRankingOfAllCimeros');
    Route::get('/statistics/provincesbycompletion', 'Api\ApiTablesController@getRankingOfProvincesByCompletion');
    Route::get('/statistics/comunidadsbycompletion', 'Api\ApiTablesController@getRankingOfCommunidadsByCompletion');
    Route::get('/statistics/cimerosbycommunidadscompleted', 'Api\ApiTablesController@getRankingOfCimerosByCommunidadCompletion');
    Route::get('/statistics/cimerosbyprovincescompleted', 'Api\ApiTablesController@getRankingOfCimerosByProvinciaCompletion');

    // Temporary - need rerouting via api:auth

    Route::get('/userlogros', function() {
        return App\Cimero::find(1060)->logros()->get()->pluck('cima_id')->toArray();
    });
    
});
