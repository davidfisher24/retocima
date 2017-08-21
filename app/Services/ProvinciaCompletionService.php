<?php

namespace App\Services;

use DB;

use App\Cimero;
use App\Cima;
use App\Logro;
use App\Provincia;
use App\Communidad;


class ProvinciaCompletionService
{

	/**
    * tests if a cimero has completed a province
    * 
    * @param integer $cimeroId
    * @param integer $provinceId
    *
    * @return boolean 
    */

	public function hasCimeroCompletedProvince($cimeroId,$provinceId)
	{
		$province = Provincia::find($provinceId)->cimas()->where('estado',1)->get()->pluck('codigo')->toArray(); 
		$cimero = Cimero::find($cimeroId)->logros()->where('provincia_id',$provinceId)->get()->pluck('cima_codigo')->toArray(); 
		return !array_diff($province,$cimero);
	}

	/**
    * gets all the completed provinces for a cimero
    * 
    * @param integer $cimeroId
    *
    * @return collection
    */


	public function getCimerosCompletedProvinces($cimeroId)
	{
		
		return Provincia::all()->filter(function ($item) use ($cimeroId) {
			return $this->hasCimeroCompletedProvince($cimeroId,$item->id);
		});

	}

}

//$c = new App\Services\ProvinciaCompletionService()
//$c->hasCimeroCompletedProvince(44,5);
//$c->getCimerosCompletedProvinces(44)
