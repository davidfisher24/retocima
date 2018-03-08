<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

use App\Cima;

class CimaController extends Controller
{


    public function __construct()
    {

    }

    /*
     * Finds all cimas in a province
     */
    public function oneAction($id)
    {
    	return Cima::with('provincia','communidad','vertientes')->withCount('logros')->find($id)->toJSON();
    }

    /*
     * Finds all cimas in a province
     */
    public function allAction()
    {
    	return Cima::with('provincia','communidad','vertientes')->withCount('logros')->get()->toJSON();
    }

    /*
     * Finds all cimas in a province
     */
    public function allInProviceAction($provinciaId)
    {
    	return Cima::where('provincia_id',$provinciaId)->with('vertientes','vertientes.enlaces')->withCount('logros')->get()->toJSON();
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

}
