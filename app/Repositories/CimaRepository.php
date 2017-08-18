<?php

namespace App\Repositories;

use DB;

use App\Cima;
use App\Communidad;
use App\Provincia;

class CimaRepository 
{
	public function getCommunidadListWithCimasCount(){
        /*return Cima::groupBy('communidad_id')->select('communidad_id',DB::raw('count(*) as total'))->get()->map(function($item, $index){
            $item->communidad = Communidad::find($item->communidad_id)->nombre;
            return $item;
        })->sortBy('communidad');*/

        return Cima::groupBy('communidad_id')->select('communidad_id',DB::raw('count(*) as total'))->with('communidad')->get()->sortBy('communidad');
	}

	public function getProvinciaListWithCimasCount($communidadId){

        /*return Cima::groupBy('provincia_id')->select('provincia_id',DB::raw('count(*) as total'))->get()->map(function($item, $index){
            $item->provincia = Provincia::find($item->provincia_id)->nombre;
            return $item;
        })->sortBy('provincia');*/

        return Cima::where('communidad_id',$communidadId)->with('provincia')->groupBy('provincia_id')->select('provincia_id',DB::raw('count(*) as total'))->get()->sortBy('provincia');
	}

	public function getCimaById($id){
		return Cima::with('vertientes','provincia','communidad','iberia')->find(1);
	}

	public function getCimasInProvincia($id){
		return Cima::where('provincia_id',$id)->get();
	}

	public function getCimasInCommunidad($id){
		return Cima::where('communidad_id',$id)->get();
	}


}