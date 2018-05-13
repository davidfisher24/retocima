<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

use App\Cimero;
use App\Cima;
use App\Logro;
use App\Communidad;
use App\Provincia;

use App\Services\AreaCompletionService;


class CimeroController extends Controller
{

    public function __construct(AreaCompletionService $areaCompletionService)
    {
        $this->areaCompletionService = $areaCompletionService;
    }

    /*
     * All Cimeros ranked by logros
     */
    // select cimeros.id, count(logros.cimero_id) as logros_count from cimeros left join logros on cimeros.id = logros.cimero_id group by cimeros.id;
    //select cimeros.id, count(logros.cimero_id) as logros_count from cimeros left join logros on cimeros.id = logros.cimero_id where logros.cima_id in (1,2) group by cimeros.id;

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
	        ->groupBy('cimeros.id')
	        ->orderBy('logros_count','desc')
	        ->get();

        return json_encode(["data" => $cimeros->map(function($c,$i){
            $c->rank = $i + 1;
            if ($c->logros_count > 640) $c->image = 'crown';
            else if ($c->logros_count >= 480 && $c->logros_count <= 640) $c->image = 'gold';
            else if ($c->logros_count < 480 && $c->logros_count >= 320) $c->image = 'silver';
            else if ($c->logros_count >= 160 && $c->logros_count < 320) $c->image = 'bronze';
            else $c->image = null;
            return $c;
        })]);
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

    /*
     * All Cimeros ranked by pata negras
     */


    public function rankByPataNegraAction()
    {
        $pns =  Cima::where('pata_negra',1)->get()->pluck('id');
        $cimeros = DB::table('cimeros')
            ->select(DB::raw(
                'cimeros.*, 
                CONCAT(cimeros.nombre, " ", cimeros.apellido1, " ", COALESCE(cimeros.apellido2,"")) as fullName,
                count(distinct(logros.id)) as logros_count'
            ))
            ->leftJoin('logros', 'cimeros.id', '=', 'logros.cimero_id')
            ->whereIn('cima_id',$pns)
            ->groupBy('cimeros.id')
            ->orderBy('logros_count','desc')
            ->get();
        return $cimeros;
    }


    /*
     * All a cimeros logros
     */

    public function allLogrosAction($id){
        return Logro::with('provincia','communidad','cima')->where('cimero_id',$id)->get()->toJson();
    }

    public function profileAction($id){
        return Cimero::with('provincia','pais')->find($id)->toJson();
    }

    public function completedAreasAction($id){
        return $this->areaCompletionService->getCImerosCompletedProvincesAndCommunidads($id);
    }

    public function oneAction($id){
        $cimero = Cimero::with('provincia','pais')->find($id);
        //$logros = Logro::where('cimero_id',$id)->where('cima_estado',1)->get()->groupBy('provincia_id');
        $logros = Logro::where('cimero_id',$id)->where('cima_estado',1)->get();
        $provinces = Provincia::withCount('activeCimas')->get();
        $communidads = Communidad::withCount('activeCimas')->get();

        return array(
            "cimero" => $cimero,
            "logros" => $logros,
            "provincias" => $provinces,
            "communidads" => $communidads
        );
    }
  
}
