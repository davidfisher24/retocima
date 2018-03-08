<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

use App\Communidad;

class CommunidadController extends Controller
{


    public function __construct()
    {

    }

    public function allAction()
    {
        return Communidad::all()->toJSON();
    }

    /*
     * All Communidads ranked by logros
     */
     //select communidads.*, count(logros.communidad_id) as logros_count from communidads left join logros on communidads.id = logros.communidad_id group by communidads.id

    public function rankAction()
    {
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
    }

}
