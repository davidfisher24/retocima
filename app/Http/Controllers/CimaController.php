<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

use App\Cima;
use App\Vertiente;
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
        return Cima::select('id','codigo','nombre','estado','has_substitute','provincia_id')
        ->get()->toJSON();
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
        return Cima::where('estado',1)
        ->orderByRaw("RAND()")->take(2)->withCount('logros')
        ->get()->toJSON();
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

    /* Searchs cimas by text for ajax searcj
     *
     */
    public function advancedSearchAction(Request $request)
    {   
        $input = $request->json()->all();

        $query = Vertiente::query();
        $query = $query->whereBetween('desnivel', [$input["desnivel"][0], $input["desnivel"][1]]);
        $query = $query->whereBetween('apm', [$input["apm"][0], $input["apm"][1]]);
        $query = $query->whereBetween('longitud', [$input["longitud"][0], $input["longitud"][1]]);

        $validVertientes = $query->get();
        $toReturn = [];

        foreach ($validVertientes as $vert) {
            $cima = Cima::find($vert->cima_id);
            if (!$input["provincia"] || $input["provincia"] && $input["provincia"] == $cima->provincia_id) {
                $cima->vertiente = $vert;
                array_push($toReturn,$cima);
            }
        }

        return $toReturn;

    }

    /*
     * Finds all cimas in a province with all data linked
     */
    public function allInProviceAction($provinciaId)
    {
    	return Cima::where('provincia_id',$provinciaId)->with('provincia','communidad','vertientes','vertientes.enlaces')->withCount('logros')->get()->toJSON();
    }

    /*
     * Finds all eliminated cimas
    */
    public function eliminatedAction()
    {
        return Cima::where('estado',3)->with('provincia','communidad','vertientes','vertientes.enlaces')->withCount('logros')->get()->toJSON();
    }

    
    /*
     * Finds all pata negra cimas
     */

    public function pataNegraAction()
    {
        return Cima::with('provincia','communidad','vertientes','vertientes.enlaces')->withCount('logros')->where('pata_negra',1)->get()->toJSON();
    }

    /*
     * Finds all pata negra cimas
     */

    public function extremaAction()
    {
        return Cima::with('provincia','communidad','vertientes','vertientes.enlaces')->withCount('logros')
        ->whereIn('id',[225,246,158,421,446,38,605,609,578])->get()->toJSON();
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
     * All Cimas ranked by logros
     */
     // select cimas.*, count(logros.cima_id) as logros_count from cimas left join logros on cimas.id = logros.cima_id group by cimas.id;

    public function rankByPataNegraAction()
    {
        $pns =  Cima::where('pata_negra',1)->get()->pluck('id');
        $cimas = DB::table('cimas')
            ->select(DB::raw(
                'cimas.*, 
                count(logros.cima_id) as logros_count,
                provincias.nombre as provinciaName'
            ))
            ->leftJoin('logros', 'cimas.id', '=', 'logros.cima_id')
            ->leftJoin('provincias', 'cimas.provincia_id', '=', 'provincias.id')
            ->whereIn('cima_id',$pns)
            ->groupBy('cimas.id')
            ->orderBy('logros_count','desc')
            ->get();
        return $cimas;
    }

}
