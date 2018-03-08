<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

use App\Cimero;
use App\Logro;


class CimeroController extends Controller
{

    public function __construct()
    {

    }

    /*
     * All Cimeros ranked by logros
     */
    // select cimeros.id, count(logros.cimero_id) as logros_count from cimeros left join logros on cimeros.id = logros.cimero_id group by cimeros.id;
    //ALTER table logros ADD index cima_id (cima_id);
    //ALTER table logros ADD index provincia_id (provincia_id);
    //ALTER table logros ADD index communidad_id (communidad_id);

    public function rankAction()
    {
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
	    	->where('logros.provincia_id',7)
	        ->groupBy('cimeros.id')
	        ->orderBy('logros_count','desc')
	        ->get();
    	return $cimeros;
    }

    /*
     * All Cimeros ranked by logros in an area
     * @param {string} filter provincia, communidad
     * @param {integer} area id
     */
    //select cimeros.id, count(distinct(logros.provincia_id)) as logros_count from cimeros left join logros on cimeros.id = logros.cimero_id group by cimeros.id;

    public function rankByAreaAction($filter,$id)
    {
    	$cimeros = DB::table('cimeros')
	    	->select(DB::raw(
	    		'cimeros.*, 
	    		CONCAT(cimeros.nombre, " ", cimeros.apellido1, " ", COALESCE(cimeros.apellido2,"")) as fullName,
	    		count(logros.cimero_id) as logros_count'
	    	))
	    	->leftJoin('logros', 'cimeros.id', '=', 'logros.cimero_id')
	    	->where('logros.'.$filter.'_id',$id)
	        ->groupBy('cimeros.id')
	        ->orderBy('logros_count','desc')
	        ->get();
    	return $cimeros;
    }

    /*
     * All Cimeros ranked by provinces started
     * @param {string} filter provincia, communidad
     * @param {integer} area id
     */

    public function rankByProvincesStartedAction()
    {
		$cimeros = DB::table('cimeros')
	    	->select(DB::raw(
	    		'cimeros.*, 
	    		CONCAT(cimeros.nombre, " ", cimeros.apellido1, " ", COALESCE(cimeros.apellido2,"")) as fullName,
	    		count(distinct(logros.provincia_id)) as logros_count'
	    	))
	    	->leftJoin('logros', 'cimeros.id', '=', 'logros.cimero_id')
	        ->groupBy('cimeros.id')
	        ->orderBy('logros_count','desc')
	        ->get();
    	return $cimeros;
    }

    public function logrosArrayAction(){
        return $this->allLogros(Auth::id())->pluck('cima_id')->toArray();
    }

    public function checkLogroAction($cimaId){
        $logro = Logro::where('cima_id',$cimaId)->where('cimero_id',Auth::id())->first();
        return $logro ? $logro->toJson() : null;
    }

    private function allLogros($id)
    {
        return Cimero::find($id)->logros()->get();
    }
  
}
