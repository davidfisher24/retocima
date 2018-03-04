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
    Route::get('cimas/{id}', function($id) {
        return App\Cima::where('provincia_id',$id)->with('vertientes','vertientes.enlaces')->get()->toJSON();
    });

    Route::get('ranking',function(){
    	return App\Cimero::all();
    	$cimeros = App\Cimero::all();
    	return json_encode(array("data" => $cimeros, "count" => $cimeros->count()));
    });


});


