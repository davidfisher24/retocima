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
    * Functions to tests if a cimero has completed a province/communidad/iberia
    * Calls the getCimasNotDoneByCimeroInAnArea() function.  If this is a zero count, the area is complete.
    * 
    * @param integer $cimeroId
    * @param integer $provinceId/$communidadId/$iberiaId
    *
    * @return boolean 
    */

	public function hasCimeroCompletedProvince($cimeroId,$provinceId)
	{
		$toDo = count($this->getCimasNotDoneByCimeroInAnArea("provincia_id",$provinceId,$cimeroId));
		return $toDo === 0 ? true : false;
	}

	public function hasCimeroCompletedCommunidad($cimeroId,$communidadId)
	{
		$toDo = count($this->getCimasNotDoneByCimeroInAnArea("communidad_id",$communidadId,$cimeroId));
		return $toDo === 0 ? true : false;
	}

	public function hasCimeroCompletedIberia($cimeroId,$iberiaId)
	{
		$toDo = count($this->getCimasNotDoneByCimeroInAnArea("iberia_id",$iberiaId,$cimeroId));
		return $toDo === 0 ? true : false;
	}

	/**
    * gets all the completed provinces/communidad/iberias for a cimero
    * Calls the getAreasCompletedByACimero() function. This will return a list of ids, which is converted to eloquent models
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
    * gets all the users who have completed a province/communidad/iberia
    * Calls the getAllCimerosWhoHaveCompletedAnArea function() and then finds the user for each id
    * 
    * @param integer $provinciaId/$communidadId/$iberiaId
    *
    * @return array of eloquent models cimeros
    */

	public function getUsersWhoHaveCompletedAProvince($provinceId)
	{
		$result = $this->getAllCimerosWhoHaveCompletedAnArea('provincia_id',$provinceId);

		$returnArray = array();
		foreach ($result as $cimero) array_push($returnArray,Cimero::find($cimero->cimero_id));
		return $returnArray;
	}

	public function getUsersWhoHaveCompletedACommunidad($communidadId)
	{
		$result = $this->getAllCimerosWhoHaveCompletedAnArea('communidad_id',$communidadId);

		$returnArray = array();
		foreach ($result as $cimero) array_push($returnArray,Cimero::find($cimero->cimero_id));
		return $returnArray;
	}

	public function getUsersWhoHaveCompletedAIberia($iberiaId)
	{
		$result = $this->getAllCimerosWhoHaveCompletedAnArea('iberia_id',$iberiaId);

		$returnArray = array();
		foreach ($result as $cimero) array_push($returnArray,Cimero::find($cimero->cimero_id));
		return $returnArray;
	}

	/**
    * gets the combined completed provinces with communidads for a user
    * 
    * @param integer $cimeroId
    *
    * @return array ["provincias" => [App\Provincia,App\Provincia], "communidads" => [App\Communidad,App\Communidad]]
    */

	public function getCImerosCompletedProvincesAndCommunidads($cimeroId)
	{
		$result = $this->getCimerosCompletedProvinceAndCommunidadIds($cimeroId);

		$result["communidads"] = array_map(function($item){return Communidad::find($item);},$result["communidads"]);
		$result["provincias"] = array_map(function($item){return Provincia::find($item);},$result["provincias"]);

		return $result;
	}

	

	/**
    * Gets all provinces ordered by number of completions
    *
    * @return array of eloquent models ordered by number of completions
    */

	public function getProvincesOrderedByCompletions()
	{
		$number = Provincia::count();
		$provinces = array();

		for ($a = 1; $a <= $number; $a++) {
			$province = Provincia::find($a);
			$completions = count($this->getAllCimerosWhoHaveCompletedAnArea('provincia_id',$a));
			$provinces[$completions] = array("provincia" => $province, "completions" => $completions);
		}

		krsort($provinces);
		return array_values($provinces);
	}

	/**
    * Gets all communidads ordered by number of completions
    *
    * @return array of eloquent models ordered by number of completions
    */

	public function getCommunidadsOrderedByCompletions()
	{
		$number = Communidad::count();
		$communidads = array();

		for ($a = 1; $a <= $number; $a++) {
			$communidad = Communidad::find($a);
			$completions = count($this->getAllCimerosWhoHaveCompletedAnArea('communidad_id',$a));
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
    *
    * @return array of ids
    */

	private function getAllCimerosWhoHaveCompletedAnArea($foreign_key,$id)
	{
		$cimaCount = Cima::where($foreign_key, $id)->where('estado',1)->count();

		$rawQuery = "select * from (select count(distinct cima_codigo) as count, cimero_id from logros where ".$foreign_key." = ".$id." and cima_estado = 1 and cima_codigo in (select distinct codigo from cimas where ".$foreign_key." = ".$id." and estado = 1) group by cimero_id) as t where t.count = " . $cimaCount;
		return DB::select($rawQuery);
	}

	/**
    * performs the sql query to determine all the provinces/communidads/iberia completed by a user
    * 
    * @param foreign_key provincia_id/communidad_id/iberia_id
    * @param integer $cimeroId
    *
    * @return array of ids
    */

	private function getAreasCompletedByACimero($foreign_key,$cimeroId)
	{
		$rawQuery = "select count(distinct logros.cima_codigo) as count_logros, logros.".$foreign_key." as id, count(distinct cimas.codigo) as count_all from logros inner join cimas on logros.".$foreign_key." = cimas.".$foreign_key." where logros.cimero_id = ".$cimeroId." and logros.cima_estado = 1 and cimas.estado = 1 group by logros.".$foreign_key." HAVING count_logros = count_all";

		return DB::select($rawQuery);

	}

	/**
    * performs the sql query to determine the ids of cimas DONE by a cimero in an area
    * 
    * @param foreign_key provincia_id/communidad_id/iberia_id
    * @param integer id (provincia,communidad,iberia)
    * @param integer $cimeroId
    *
    * @return array of ids
    */

	private function getCimasDoneByCimeroInAnArea($foreign_key,$id,$cimeroId)
	{
		$rawQuery = "select id from cimas where ".$foreign_key." = ".$id." and estado = 1 and codigo in (select distinct cima_codigo from logros where cimero_id = ".$cimeroId." and ".$foreign_key." = ".$id." and cima_estado = 1);";
		return DB::select($rawQuery);
	}

	/**
    * performs the sql query to determine the ids of cimas DONE by a cimero in an area
    * 
    * @param foreign_key provincia_id/communidad_id/iberia_id
    * @param integer id (provincia,communidad,iberia)
    * @param integer $cimeroId
    *
    * @return array of ids
    */

	private function getCimasNotDoneByCimeroInAnArea($foreign_key,$id,$cimeroId)
	{
		$rawQuery = "select id from cimas where ".$foreign_key." = ".$id." and estado = 1 and codigo not in (select distinct cima_codigo from logros where cimero_id = ".$cimeroId." and ".$foreign_key." = ".$id." and cima_estado = 1);";
		return DB::select($rawQuery);
	}

	/**
    * performs an sql query to get completed communidads and provinces for a cimero. Ignores the provinces if the communidad is complete
    * 
    * @param integer $cimeroId
    *
    * @return array ("provincias" => [id,id], "communidads" => [id,id])
    */

	private function getCimerosCompletedProvinceAndCommunidadIds($cimeroId)
	{
		$queryCommunidads = DB::select('select id from(select count(distinct logros.cima_codigo) as count_logros, logros.communidad_id as id, count(distinct cimas.codigo) as count_all from logros inner join cimas on logros.communidad_id =cimas.communidad_id where logros.cimero_id = '.$cimeroId.' and logros.cima_estado = 1 and cimas.estado = 1 group by logros.communidad_id HAVING count_logros = count_all) X;');
		$communidads = collect($queryCommunidads)->map(function($x){return $x->id;})->toArray();

		$eliminateCommunidadsQuery = ""; 
		if (count($communidads) > 0) $eliminateCommunidadsQuery = 'and logros.communidad_id not in ('.implode(',',$communidads).') ';

		$queryProvincias = DB::select('select id from (select count(distinct logros.cima_codigo) as count_logros, logros.provincia_id as id, count(distinct cimas.codigo) as count_all from logros inner join cimas on logros.provincia_id =cimas.provincia_id where logros.cimero_id = '.$cimeroId.' and logros.cima_estado = 1 and cimas.estado = 1 '.$eliminateCommunidadsQuery.' group by logros.provincia_id HAVING count_logros = count_all) X;');
		$provincias = collect($queryProvincias)->map(function($x){return $x->id;})->toArray();

		return array("communidads" => $communidads, "provincias" => $provincias);

	}
	
}

//$c = new App\Services\AreaCompletionService()




