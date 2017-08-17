<?php

namespace App\Services;

use DB;

use App\Cimero;
use App\Logro;

class CimeroRankingService 
{

	/**
	 * Create a new service instance.
	 *
	 * @return void
	 */
    public function __construct()
    {
    	
    }

    /**
     * Returns all cimeros ranked by numero of logros
     *
     * @collection cimeros ranked by logros
     */

	public function getRankingOfAllCimeros(){
        return Logro::select('cimero_id',DB::raw('count(*) as logros_count'))->groupBy('cimero_id')->get()->sortByDesc('logros_count')->map(function($item){
            $cimero = $item->cimero()->first();
            $item->nombre = $cimero->nombre . " " . $cimero->apellido1 . " " . $cimero->apellido2;
            return $item;
        });

	}
}