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

// Php pages

// Javascript elements
Route::get('/listadocommunidads', function () { return view('publicarea.listadocommunidads');});
Route::get('/ranking', function () { return view('publicarea.ranking');});
Route::get('/estadistica', function () { return view('publicarea.estadistica');});
Route::get('/mapa', function () {return view('publicarea.mapa');});
Route::get('/patanegra', function () {return view('publicarea.patanegra');});
Route::get('/detallescima/{id}', function ($id) {return view('publicarea.cima',compact('id'));});
Route::get('/cimeropublicdetails/{id}', function ($id) {return view('publicarea.cimero',compact('id'));});

/* cimeroCuenta */
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', 'CimeroCuentaController@dashboard')->name('dashboard');  
    Route::post('/change-password', 'Auth\UpdatePasswordController@update');
});

/*Ajax Requests - Move to jwt in the long term*/
Route::prefix('ajax')->group(function () {
    Route::get('checklogro/{cimaId}', 'CimeroController@checkLogroAction'); // Public domain VERY CUTRE
    Route::get('discover', 'CimaController@discoverAction'); // Public but here as we might need to recommend
    // Private
    Route::get('cimero', 'CimeroCuentaController@fullAccountAction');
    Route::get('userlogros', 'CimeroCuentaController@logrosArrayAction');
    Route::get('userfulllogros', 'CimeroCuentaController@allLogrosAction');
    Route::get('userprovincialogros/{provinciaId}', 'CimeroCuentaController@provinciaLogrosAction');
    Route::post('editarcuenta', 'CimeroCuentaController@editarCuenta');
    Route::post('submitlogros', 'CimeroCuentaController@submitNewLogros');
    Route::post('update-logro', 'CimeroCuentaController@updateLogro');
    // Stats graphs
    Route::get('logrosbycommunidad', 'CimeroCuentaController@logrosByCommunidadStat');
    Route::get('logrosbyprovincia', 'CimeroCuentaController@logrosByProvinciaStat');
    Route::get('logrosbyaltitud', 'CimeroCuentaController@logrosByAltitudStat');
});

