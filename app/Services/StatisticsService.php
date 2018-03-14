<?php

namespace App\Services;

use DB;

use App\Cimero;
use App\Cima;
use App\Logro;



class StatisticsService
{

	/**
    * Get list of pata negra cimas
    *
    * @return collection
    */

    public function cimeroLogrosByCommunidad($cimeroId)
    {
        return Logro::with('communidad')->where('cimero_id',$cimeroId)->get()->groupBy('communidad_id')->map(function ($item, $key) {
            $item->first()->communidad->count = $item->count();
            return $item->first()->communidad;
        })->sortByDesc('count')->flatten();
    }

}


