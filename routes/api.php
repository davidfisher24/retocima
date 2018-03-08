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
	    		CONCAT(cimeros.nombre, " ", cimeros.apellido1, " ", COALESCE(cimeros.apellido2,"")) as fullName,
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

    //ALTER table logros ADD index cima_id (cima_id);
    //ALTER table logros ADD index provincia_id (provincia_id);
    //ALTER table logros ADD index communidad_id (communidad_id);
    // select cimas.*, count(logros.cima_id) as logros_count from cimas left join logros on cimas.id = logros.cima_id group by cimas.id;
    //select provincias.*, count(logros.provincia_id) as logros_count from provincias left join logros on provincias.id = logros.provincia_id group by provincias.id
    //select communidads.*, count(logros.communidad_id) as logros_count from communidads left join logros on communidads.id = logros.communidad_id group by communidads.id
    Route::get('cimasranking',function(){
    	$cimas = DB::table('cimas')
	    	->select(DB::raw(
	    		'cimas.*, 
	    		count(logros.cima_id) as logros_count,
	    		provincias.nombre as provinciaName'
	    	))
	    	->leftJoin('logros', 'cimas.id', '=', 'logros.cima_id')
	    	->leftJoin('provincias', 'cimas.provincia_id', '=', 'provincias.id')
	        ->groupBy('cimas.id')
	        ->orderBy('logros_count','desc')
	        ->get();
    	return $cimas;
    });
    Route::get('provinciasranking',function(){
    	$provincias = DB::table('provincias')
	    	->select(DB::raw(
	    		'provincias.*, 
	    		count(logros.provincia_id) as logros_count'
	    	))
	    	->leftJoin('logros', 'provincias.id', '=', 'logros.provincia_id')
	        ->groupBy('provincias.id')
	        ->orderBy('logros_count','desc')
	        ->get();
    	return $provincias;
    });
    Route::get('communidadsranking',function(){
    	$communidads = DB::table('communidads')
	    	->select(DB::raw(
	    		'communidads.*, 
	    		count(logros.communidad_id) as logros_count'
	    	))
	    	->leftJoin('logros', 'communidads.id', '=', 'logros.communidad_id')
	        ->groupBy('communidads.id')
	        ->orderBy('logros_count','desc')
	        ->get();
    	return $communidads;
    });

});


