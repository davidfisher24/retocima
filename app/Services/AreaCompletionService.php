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
    * @return array of eloquent models Provincia/Communidad/Iberia
    */


	public function getCimerosCompletedProvinces($cimeroId)
	{
		$results = array();
		foreach ($this->getAreasCompletedByACimero('provincia_id',$cimeroId) as $area) {
		    $results[] = Provincia::find($area->id);
		}
		return $results;
	}

	public function getCimerosCompletedCommunidads($cimeroId)
	{
		$results = array();
		foreach ($this->getAreasCompletedByACimero('communidad_id',$cimeroId) as $area) {
		    $results[] = Communidad::find($area->id);
		}
		return $results;
	}

	public function getCimerosCompletedIberias($cimeroId)
	{
		$results = array();
		foreach ($this->getAreasCompletedByACimero('iberia_id',$cimeroId) as $area) {
		    $results[] = Iberia::find($area->id);
		}
		return $results;
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
    * @return array
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
    * Gets all provinces ordered by number of completions
    *
    * @return array orders by completions
    */

	public function getProvincesOrderedByCompletions()
	{
		$number = Provincia::count();
		$provinces = array();

		for ($a = 1; $a <= $number; $a++) {
			$province = Provincia::find($a);
			$completions = $this->getAllCimerosWhoHaveCompletedAnArea('provincia_id',$a, $count = true);
			$provinces[$completions] = array("provincia" => $province, "completions" => $completions);
		}

		krsort($provinces);
		return array_values($provinces);
	}

	/**
    * Gets all communidads ordered by number of completions
    *
    * @return array orders by completions
    */

	public function getCommunidadsOrderedByCompletions()
	{
		$number = Communidad::count();
		$communidads = array();

		for ($a = 1; $a <= $number; $a++) {
			$communidad = Communidad::find($a);
			$completions = $this->getAllCimerosWhoHaveCompletedAnArea('communidad_id',$a, $count = true);
			$communidads[$completions] = array("communidad" => $communidad, "completions" => $completions);
		}

		krsort($communidads);
		return array_values($communidads);
	}

	/**
    * performs the sql query to determine all the users who have completed a province/communidad/iberia
    * 
    * @param foreign_key provincia_id/communidad_id/iberia_id
    * @param integer $id
    * @param boolean $count  return only the count or full data
    *
    * @return array $returnArray
    */

	private function getAllCimerosWhoHaveCompletedAnArea($foreign_key,$id, $count = false)
	{
		$cimaCount = Cima::where($foreign_key, $id)->where('estado',1)->count();

		$rawQuery = "select * from (select count(distinct cima_codigo) as count, cimero_id from logros where ".$foreign_key." = ".$id." and cima_estado = 1 and cima_codigo in (select distinct codigo from cimas where ".$foreign_key." = ".$id." and estado = 1) group by cimero_id) as t where t.count = " . $cimaCount;
		$result = DB::select($rawQuery);

		$returnArray = array();

		foreach ($result as $cimero) array_push($returnArray,Cimero::find($cimero->cimero_id));

		if ($count) return count($returnArray);
		else return $returnArray;
	}

	/**
    * performs the sql query to determine all the provinces/communidads/iberia completed by a user
    * 
    * @param foreign_key provincia_id/communidad_id/iberia_id
    * @param integer $cimeroId
    *
    * @return array $completedAreas
    */

	private function getAreasCompletedByACimero($foreign_key,$cimeroId)
	{
		$rawQuery = "select count(distinct logros.cima_codigo) as count_logros, logros.".$foreign_key." as id, count(distinct cimas.codigo) as count_all from logros inner join cimas on logros.".$foreign_key." = cimas.".$foreign_key." where logros.cimero_id = ".$cimeroId." and logros.cima_estado = 1 and cimas.estado = 1 group by logros.".$foreign_key." HAVING count_logros = count_all";

		return DB::select($rawQuery);

	}
	
}

//$c = new App\Services\AreaCompletionService()
//$c->getUsersWhoHaveCompletedAProvince(1)

//select count(distinct logros.cima_codigo) as count_logros, logros.provincia_id as id, count(distinct cimas.codigo) as count_all from logros inner join cimas on logros.provincia_id =cimas.provincia_id where logros.cimero_id = 2 and logros.cima_estado = 1 and cimas.estado = 1 group by logros.provincia_id HAVING count_logros = count_all;

//select * from (select count(distinct cima_codigo) as count, cimero_id from logros where provincia_id = 1 and cima_estado = 1 and cima_codigo in (select distinct codigo from cimas where provincia_id = 1 and estado = 1) group by cimero_id) as t where t.count = 11;