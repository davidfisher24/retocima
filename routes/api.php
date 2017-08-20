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
    Route::get('communidads', function() {
        return App\Communidad::all()->toJSON();
    });
 
    Route::get('provincias/{id}', function($id) {
        return App\Provincia::where('communidad_id',$id)->get()->toJSON();
    });
 
    Route::get('cimas/{id}', function($id) {
        return App\Cima::where('provincia_id',$id)->get()->toJSON();
    });

    // Temporary - need rerouting via api:auth

    Route::get('/userlogros', function() {
        return App\Cimero::find(1060)->logros()->get()->pluck('cima_id')->toArray();
    });
    
});
