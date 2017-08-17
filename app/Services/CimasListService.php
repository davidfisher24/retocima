<?php

namespace App\Services;

use DB;

use App\Cima;
use App\Logro;
use App\Communidad;

class CimasListService 
{

	/**
	 * Create a new service instance.
	 *
	 * @return void
	 */
    public function __construct()
    {
    	
    }

	public function getCommunidadsWithNumberOfCimas(){
        return Cima::groupBy('communidad_id')->select('communidad_id',DB::raw('count(*) as total'))->get()->map(function($item, $index){
            $item->communidad = Communidad::find($item->communidad_id)->nombre;
            return $item;
        })->sortBy('communidad');
	}
}