<?php

namespace App\Services;

use DB;

use App\Cimero;
use App\Cima;
use App\Logro;
use App\Provincia;
use App\Communidad;
use App\Iberia;


class AreaCompletionService
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
		return Provincia::all()->filter(function($item) use ($cimeroId) {
			$provincia = $item->cimas()->where('estado',1)->get()->pluck('codigo')->toArray();
			$logros = Logro::where('cimero_id',$cimeroId)->where('provincia_id',$item->id)->get()->unique('cima_codigo')->pluck('cima_codigo')->toArray();
			return !array_diff($provincia,$logros);
		});
	}

	public function getCimerosCompletedCommunidads($cimeroId)
	{
		return Communidad::all()->filter(function($item) use ($cimeroId) {
			$communidad = $item->cimas()->where('estado',1)->get()->pluck('codigo')->toArray();
			$logros = Logro::where('cimero_id',$cimeroId)->where('communidad_id',$item->id)->get()->unique('cima_codigo')->pluck('cima_codigo')->toArray();
			return !array_diff($communidad,$logros);
		});
	}

	public function getCimerosCompletedIberias($cimeroId)
	{
		return Iberia::all()->filter(function($item) use ($cimeroId) {
			$iberia = $item->cimas()->where('estado',1)->get()->pluck('codigo')->toArray();
			$logros = Logro::where('cimero_id',$cimeroId)->where('iberia_id',$item->id)->get()->unique('cima_codigo')->pluck('cima_codigo')->toArray();
			return !array_diff($iberia,$logros);
		});
	}

	/**
    * gets the combined completed provinces with communidads for a user
    * 
    * @param integer $cimeroId
    *
    * @return collection
    */

	public function getCImerosCompletedProvincesAndCommunidads($cimeroId)
	{

		return $this->getCimerosCompletedProvinces($cimeroId)->groupBy('communidad_id')->map(function($item) {
			if (Provincia::where('communidad_id',$item->first()->communidad_id)->count() === count($item)) 
				return Communidad::find($item->first()->communidad_id);
			else return $item;
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
		return $this->getAllCimerosWhoHaveCompletedAnArea('provincia_id',$provinceId);
	}

	public function getUsersWhoHaveCompletedACommunidad($communidadId)
	{
		return $this->getAllCimerosWhoHaveCompletedAnArea('communidad_id',$communidadId);
	}

	public function getUsersWhoHaveCompletedAIberia($iberiaId)
	{
		return $this->getAllCimerosWhoHaveCompletedAnArea('iberia_id',$iberiaId);
	}

	/**
    * performs the sql query to determine the users who have completed a province/communidad/iberia
    * 
    * @param foreign_key provincia_id/communidad_id/iberia_id
    * @param integer $id
    *
    * @return collection
    */

	private function getAllCimerosWhoHaveCompletedAnArea($foreign_key,$id)
	{
		$cimaCount = Cima::where($foreign_key, $id)->where('estado',1)->count();

		$rawQuery = "select * from (select count(distinct cima_codigo) as count, cimero_id from logros where ".$foreign_key." = ".$id." and cima_estado = 1 and cima_codigo in (select distinct codigo from cimas where ".$foreign_key." = ".$id." and estado = 1) group by cimero_id) as t where t.count = " . $cimaCount;
		$result = DB::select($rawQuery);

		$returnArray = array();

		foreach ($result as $cimero) array_push($returnArray,Cimero::find($cimero->cimero_id));
		return $returnArray;
	}

}

//$c = new App\Services\AreaCompletionService()
//$c->getUsersWhoHaveCompletedAProvince(1)
