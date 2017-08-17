<?php

namespace App\Services;

use App\Cimero;

class CimeroRankingService extends BaseService
{

    /**
     * Returns all cimeros ranked by numero of logros
     *
     * @collection cimeros ranked by logros
     */

	public function getRankingOfAllCimeros(){
        /*return Logro::select('cimero_id',DB::raw('count(*) as logros_count'))->groupBy('cimero_id')->get()->sortByDesc('logros_count')->map(function($item){
            $cimero = $item->cimero()->first();
            $item->nombre = $cimero->nombre . " " . $cimero->apellido1 . " " . $cimero->apellido2;
            return $item;
        });*/

        return $this->countLogros('cimero_id')->map(function($item){
            $cimero = $item->cimero()->first();
            $item->nombre = $cimero->nombre . " " . $cimero->apellido1 . " " . $cimero->apellido2;
            return $item;
        });

	}
}