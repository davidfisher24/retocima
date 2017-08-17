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

Route::get('/listado', 'CimasController@listCimas')->name('cimas');

Route::get('/ranking', 'CimeroStatisticsController@baseRanking')->name('ranking');

Route::get('/dashboard', 'CimeroController@dashboard')->name('dashboard');
Route::get('/cimerocuenta', 'CimeroController@cimeroCuenta')->name('cimeroCuenta');
Route::get('/cimerologros', 'CimeroController@cimeroLogros')->name('cimeroLogros');
