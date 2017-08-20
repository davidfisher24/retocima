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
Route::get('/ranking', 'CimeroRankingController@baseRanking')->name('ranking');
Route::get('/cimeropublicdetails/{id}', 'CimeroRankingController@cimeroPublicDetails')->name('cimero');

/* statistics */
Route::get('/estadistica', 'StatisticsController@testView')->name('estadistics');

/* cimeroCuenta */
Route::get('/dashboard', 'CimeroCuentaController@dashboard')->name('dashboard');
Route::get('/cimerocuenta', 'CimeroCuentaController@cimeroCuenta')->name('cimeroCuenta');
Route::get('/cimerologros', 'CimeroCuentaController@cimeroLogros')->name('cimeroLogros');
Route::get('/cimerologrosnew/{new}', 'CimeroCuentaController@cimeroLogrosWithNewLogros')->name('cimeroLogros');
Route::get('/anadirlogros', 'CimeroCuentaController@anadirLogros')->name('anadirLogros');
Route::post('/submitlogros', 'CimeroCuentaController@submitNewLogros')->name('SubmitNewLogros');
