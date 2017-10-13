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

/* Map */
Route::get('/mapa', 'MapController@showInitialMapPage')->name('mapa');

/* Pata Negra */
Route::get('/patanegra', 'PataNegraController@showInitialPataNegraPage')->name('patanegra');

/* cimeroCuenta */
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', 'CimeroCuentaController@dashboard')->name('dashboard');
    Route::get('/cimerocuenta', 'CimeroCuentaController@cimeroCuenta')->name('cimeroCuenta');
    Route::get('/cimerologros', 'CimeroCuentaController@cimeroLogros')->name('cimeroLogros');
    Route::get('/cimeroestadistica', 'CimeroCuentaController@cimeroStatistics')->name('cimeroStatistics');
    Route::get('/cimerologrosnew/{new}', 'CimeroCuentaController@cimeroLogrosWithNewLogros')->name('cimeroLogros');
    Route::get('/anadirlogros', 'CimeroCuentaController@anadirLogros')->name('anadirLogros');
    Route::post('/submitlogros', 'CimeroCuentaController@submitNewLogros')->name('SubmitNewLogros');
    Route::get('/change-password', function() {return view('userarea.change-password'); });
    Route::post('/change-password', 'Auth\UpdatePasswordController@update');
});

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

    Route::get('/ranking/baseranking', 'Ajax\AjaxTablesController@baseCimeroRanking');
    Route::get('/statistics/cimasbylogro', 'Ajax\AjaxTablesController@getAllCimasRankedByLogros');
    Route::get('/statistics/cimerosbyprovincesstarted', 'Ajax\AjaxTablesController@getCimerosWithProvinciasWithAtLeastOneLogro');
    Route::get('/statistics/provincesbylogro', 'Ajax\AjaxTablesController@getAllProvinciasRankedByLogros');
    Route::get('/statistics/comunidadsbylogro', 'Ajax\AjaxTablesController@getAllCommunidadsRankedByLogros');
    Route::get('/statistics/cimerosbylogroinzones/{filter}/{id}', 'Ajax\AjaxTablesController@getRankingOfAllCimeros');
    Route::get('/statistics/provincesbycompletion', 'Ajax\AjaxTablesController@getRankingOfProvincesByCompletion');
    Route::get('/statistics/comunidadsbycompletion', 'Ajax\AjaxTablesController@getRankingOfCommunidadsByCompletion');
    Route::get('/statistics/cimerosbycommunidadscompleted', 'Ajax\AjaxTablesController@getRankingOfCimerosByCommunidadCompletion');
    Route::get('/statistics/cimerosbyprovincescompleted', 'Ajax\AjaxTablesController@getRankingOfCimerosByProvinciaCompletion');

    Route::middleware(['auth'])->group(function () {
        Route::get('/userlogros', function() {
            return App\Cimero::find(Auth::id())->logros()->get()->pluck('cima_id')->toArray();
        }); 
    });

});

Route::prefix('test')->group(function () {
    Route::get('/', 'TestController@showTestPage');
});


