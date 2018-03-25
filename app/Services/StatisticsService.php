<?php

namespace App\Services;

use DB;

use App\Cimero;
use App\Cima;
use App\Logro;



class StatisticsService
{



    public function cimeroLogrosByCommunidad($cimeroId)
    {
        return Logro::with('communidad')->where('cimero_id',$cimeroId)->get()->groupBy('communidad_id')->map(function ($item, $key) {
            $item->first()->communidad->count = $item->count();
            return $item->first()->communidad;
        })->sortByDesc('count')->flatten();
    }

    public function cimeroLogrosByProvince($cimeroId)
    {
        return Logro::with('provincia')->where('cimero_id',$cimeroId)->get()->groupBy('provincia_id')->map(function ($item, $key) {
            $item->first()->provincia->count = $item->count();
            return $item->first()->provincia;
        })->sortByDesc('count')->flatten();
    }

    public function cimasSetByAltitud($query)
    {   
        return Cima::with('vertientes')->whereIn('id',$query)->get()->filter(function ($item) {
            return count($item->vertientes) > 0;
        })->map(function($item,$key){
            $item->altitud = $item->vertientes->first()->altitud;
            return $item;
        })->sortByDesc('altitud')->flatten();
    }

}


