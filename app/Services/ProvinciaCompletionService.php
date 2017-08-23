<?php

namespace App\Services;

use DB;

use App\Cimero;
use App\Cima;
use App\Logro;
use App\Provincia;
use App\Communidad;
use App\Iberia;


class ProvinciaCompletionService
{

	/**
    * functions to tests if a cimero has completed a province/communidad/iberia
    * 
    * @param integer $cimeroId
    * @param integer $provinceId/$communidadId/$iberiaId
    *
    * @return boolean 
    */

	public function hasCimeroCompletedProvince($cimeroId,$provinceId)
	{
		$province = Provincia::find($provinceId)->cimas()->where('estado',1)->get()->pluck('codigo')->toArray(); 
		$cimero = Cimero::find($cimeroId)->logros()->where('provincia_id',$provinceId)->get()->pluck('cima_codigo')->toArray(); 
		return !array_diff($province,$cimero);
	}

	public function hasCimeroCompletedCommunidad($cimeroId,$communidadId)
	{
		$communidad = Communidad::find($communidadId)->cimas()->where('estado',1)->get()->pluck('codigo')->toArray(); 
		$cimero = Cimero::find($cimeroId)->logros()->where('communidad_id',$communidadId)->get()->pluck('cima_codigo')->toArray(); 
		return !array_diff($communidad,$cimero);
	}

	public function hasCimeroCompletedIberia($cimeroId,$iberiaId)
	{
		$iberia = Communidad::find($iberiaId)->cimas()->where('estado',1)->get()->pluck('codigo')->toArray(); 
		$cimero = Cimero::find($cimeroId)->logros()->where('communidad_id',$iberiaId)->get()->pluck('cima_codigo')->toArray(); 
		return !array_diff($iberia,$cimero);
	}

	/**
    * gets all the completed provinces/communidad/iberias for a cimero
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

	public function getCimerosCompletedCommunidads($cimeroId)
	{
		
		return Communidad::all()->filter(function ($item) use ($cimeroId) {
			return $this->hasCimeroCompletedCommunidad($cimeroId,$item->id);
		});

	}

	public function getCimerosCompletedIberias($cimeroId)
	{
		
		return Iberia::all()->filter(function ($item) use ($cimeroId) {
			return $this->hasCimeroCompletedIberia($cimeroId,$item->id);
		});

	}

	/**
    * gets all the users who have completed a province/communidad/iberia
    * 
    * @param integer $provinciaId/$communidadId/$iberiaId
    *
    * @return collection
    */

	public function getUsersWhoHaveCompletedAProvince($provinceId)
	{
		$provinceCimas = Provincia::find($provinceId)->cimas()->where('estado',1)->get()->pluck('codigo')->toArray();
		$count = count($provinceCimas);

		$cimeros = Logro::whereIn('cima_codigo',$provinceCimas)->get()->groupBy('cimero_id')->filter(function($item) use ($count) {
			return count($item) >= $count;
		});

		return $cimeros->map(function($item){
			$id = $item->first()->cimero_id;
			return Cimero::find($id);
		});
	}

	public function getUsersWhoHaveCompletedACommunidad($communidadId)
	{
		$communidadCimas = Communidad::find($communidadId)->cimas()->where('estado',1)->get()->pluck('codigo')->toArray();
		$count = count($communidadCimas);

		$cimeros = Logro::whereIn('cima_codigo',$communidadCimas)->get()->groupBy('cimero_id')->filter(function($item) use ($count) {
			return count($item) >= $count;
		});

		return $cimeros->map(function($item){
			$id = $item->first()->cimero_id;
			return Cimero::find($id);
		});
	}

	public function getUsersWhoHaveCompletedAIberia($iberiaId)
	{
		$iberiaCimas = Iberia::find($iberiaId)->cimas()->where('estado',1)->get()->pluck('codigo')->toArray();
		$count = count($iberiaCimas);

		$cimeros = Logro::whereIn('cima_codigo',$iberiaCimas)->get()->groupBy('cimero_id')->filter(function($item) use ($count) {
			return count($item) >= $count;
		});

		return $cimeros->map(function($item){
			$id = $item->first()->cimero_id;
			return Cimero::find($id);
		});
	}

}

//$c = new App\Services\ProvinciaCompletionService()

