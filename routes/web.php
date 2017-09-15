<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


/* cimasListado */
Route::get('/listadocommunidads', 'CimasListadoController@listCimasByCommunidad')->name('communidads');
Route::get('/listadoprovincias/{id}', 'CimasListadoController@listCimasByProvincia')->name('provincias');
Route::get('/listadoprovincias/{id}/{currentProv}', 'CimasListadoController@listCimasByProvincia')->name('provincias');
Route::get('/detallescima/{id}', 'CimasListadoController@showCimaDetails')->name('cima');

/* cimeroRanking */
Route::get('/ranking', 'CimeroRankingController@displayRankingPage')->name('ranking');
Route::get('/cimeropublicdetails/{id}', 'CimeroRankingController@cimeroPublicDetails')->name('cimero');

/* statistics */
Route::get('/estadistica', 'StatisticsController@showStatisticsHomePage')->name('estadistics');

/* cimeroCuenta */
Route::get('/dashboard', 'CimeroCuentaController@dashboard')->name('dashboard');
Route::get('/cimerocuenta', 'CimeroCuentaController@cimeroCuenta')->name('cimeroCuenta');
Route::get('/cimerologros', 'CimeroCuentaController@cimeroLogros')->name('cimeroLogros');
Route::get('/cimerologrosnew/{new}', 'CimeroCuentaController@cimeroLogrosWithNewLogros')->name('cimeroLogros');
Route::get('/anadirlogros', 'CimeroCuentaController@anadirLogros')->name('anadirLogros');
Route::post('/submitlogros', 'CimeroCuentaController@submitNewLogros')->name('SubmitNewLogros');

/*Map */
Route::get('/mapa', 'MapController@showInitialMapPage')->name('mapa');

/*Ajax Requests */
Route::prefix('ajax')->group(function () {
    
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

    Route::get('/ranking/baseranking', 'Api\ApiTablesController@baseCimeroRanking');
    Route::get('/statistics/cimasbylogro', 'Api\ApiTablesController@getAllCimasRankedByLogros');
    Route::get('/statistics/cimerosbyprovincesstarted', 'Api\ApiTablesController@getCimerosWithProvinciasWithAtLeastOneLogro');
    Route::get('/statistics/provincesbylogro', 'Api\ApiTablesController@getAllProvinciasRankedByLogros');
    Route::get('/statistics/comunidadsbylogro', 'Api\ApiTablesController@getAllCommunidadsRankedByLogros');
    Route::get('/statistics/cimerosbylogroinzones/{filter}/{id}', 'Api\ApiTablesController@getRankingOfAllCimeros');
    Route::get('/statistics/provincesbycompletion', 'Api\ApiTablesController@getRankingOfProvincesByCompletion');
    Route::get('/statistics/comunidadsbycompletion', 'Api\ApiTablesController@getRankingOfCommunidadsByCompletion');
    Route::get('/statistics/cimerosbycommunidadscompleted', 'Api\ApiTablesController@getRankingOfCimerosByCommunidadCompletion');
    Route::get('/statistics/cimerosbyprovincescompleted', 'Api\ApiTablesController@getRankingOfCimerosByProvinciaCompletion');


    Route::get('/userlogros', function() {
        return App\Cimero::find(Auth::id())->logros()->get()->pluck('cima_id')->toArray();
	});


});

