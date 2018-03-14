<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

use App\Provincia;

class ProvinciaController extends Controller
{


    public function __construct()
    {

    }

    public function allAction()
    {
        return Provincia::all()->toJson();
    }

    public function communidadAction($communidadId)
    {
        return Provincia::where('communidad_id',$communidadId)->get()->toJson();
    }

    /*
     * All Provincias ranked by logros
     */
    //select provincias.*, count(logros.provincia_id) as logros_count from provincias left join logros on provincias.id = logros.provincia_id group by provincias.id

    public function rankAction()
    {
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
    }

}
