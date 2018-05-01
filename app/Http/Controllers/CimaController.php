<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

use App\Cima;
use App\Logro;

class CimaController extends Controller
{

    /*
     * Finds all cimas with latitude and longitude data
     */

    public function markersAction()
    {
        return Cima::select('id','codigo','nombre','latitude','longitude','estado')->get()->toJSON();
    }

    /*
     * Finds all cimas with latitude and longitude data
     */

    public function namesAction()
    {
        return Cima::select('id','codigo','nombre','estado','provincia_id')->get()->toJSON();
    }

    /*
     * Finds one cima with all data linked
     */
    public function oneAction($id)
    {
    	return Cima::with('provincia','communidad','vertientes','vertientes.enlaces')->withCount('logros')->find($id)->toJSON();
    }

    /* 
     * Returns two random cimas for the temporary discover action
     */
    public function discoverAction()
    {
        return Cima::orderByRaw("RAND()")->take(2)->withCount('logros')->get()->toJSON();
    }

    /*
     * Finds all cimas with all data linked (slow)
     */
    public function allAction()
    {
    	return Cima::with('provincia','communidad','vertientes','vertientes.enlaces')->withCount('logros')->get()->toJSON();
    }

    /* Searchs cimas by text for ajax searcj
     *
     */
    public function searchAction($query)
    {
        return Cima::Search($query)->get()->toJSON();
    }

    /*
     * Finds all cimas in a province with all data linked
     */
    public function allInProviceAction($provinciaId)
    {
    	return Cima::where('provincia_id',$provinciaId)->with('provincia','communidad','vertientes','vertientes.enlaces')->withCount('logros')->get()->toJSON();
    }

    /*
     * All Cimas ranked by logros
     */
     // select cimas.*, count(logros.cima_id) as logros_count from cimas left join logros on cimas.id = logros.cima_id group by cimas.id;

    public function rankAction()
    {
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
    }

    /*
     * Finds all pata negra cimas
     */

    public function pataNegraAction()
    {
        return Cima::with('provincia','communidad','vertientes','vertientes.enlaces')->withCount('logros')->where('pata_negra',1)->get()->toJSON();
    }



    

}
