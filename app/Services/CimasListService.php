<?php

namespace App\Services;

use App\Cima;
use App\Logro;
use App\Communidad;

class CimasListService extends BaseService
{

	public function getCommunidadsWithNumberOfCimas(){
        return Cima::groupBy('communidad_id')->select('communidad_id',DB::raw('count(*) as total'))->get()->map(function($item, $index){
            $item->communidad = Communidad::find($item->communidad_id)->nombre;
            return $item;
        })->sortBy('communidad');
	}
}