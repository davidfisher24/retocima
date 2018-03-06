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
    Route::get('cimas/{id}', function($id) {
        return App\Cima::where('provincia_id',$id)->with('vertientes','vertientes.enlaces')->get()->toJSON();
    });

    Route::get('ranking',function(){
    	$cimeros = DB::table('cimeros')
	    	->select(DB::raw(
	    		'cimeros.*, 
	    		CONCAT(cimeros.nombre, " ", cimeros.apellido1, " ", cimeros.apellido2) as fullName,
	    		count(logros.cimero_id) as logros_count, 
	    		provincias.nombre as provinciaName, 
	    		paises.nombre as paisName'
	    	))
	    	->leftJoin('logros', 'cimeros.id', '=', 'logros.cimero_id')
	    	->leftJoin('provincias', 'cimeros.provincia', '=', 'provincias.id')
	    	->leftJoin('paises', 'cimeros.pais', '=', 'paises.id')
	        ->groupBy('cimeros.id')
	        ->orderBy('logros_count','desc')
	        ->get();
    	return $cimeros;
    });

});


