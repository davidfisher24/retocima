<?php

namespace App\Services;

use DB;

use App\Cimero;
use App\Logro;

class CimeroRankingService 
{

    

    /**
     * Returns all cimeros ranked by numero of logros
     *
     * @return collection cimeros ranked by logros
     */

	public function getRankingOfAllCimeros(){

        return $this->countLogrosByAForeignKey('cimero_id')->map(function($item){
            $cimero = $item->cimero()->first();
            $item->nombre = $cimero->nombre . " " . $cimero->apellido1 . " " . $cimero->apellido2;
            return $item;
        });

	}

    /**
     * counts number of logros in groups by a foreign key
     *
     * @param string $foreign_key (cimero_id,cima_id,provincia_id,communidad_id,iberia_id)
     *
     * @return collection foreign keys ids with logros count
     */

    private function countLogrosByAForeignKey($foreign_key){
        return Logro::select($foreign_key,DB::raw('count(*) as logros_count'))->groupBy($foreign_key)->get()->sortByDesc('logros_count');
    }
}