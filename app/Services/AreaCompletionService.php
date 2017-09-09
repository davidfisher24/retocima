<?php

namespace App\Services;

use DB;

use App\Cimero;
use App\Cima;
use App\Logro;
use App\Provincia;
use App\Communidad;
use App\Iberia;


class AreaCompletionService extends BaseService
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
    * @return eloquent collection of provinces ordered by number of completions
    */

	public function getProvincesOrderedByCompletions()
	{
		$provinces = Provincia::all();
		$provinces->map(function($item){
			$item->completions = count($this->getAllCimerosWhoHaveCompletedAnArea('provincia_id',$item->id));
			return $item;
		});

		$provinces = $provinces->sortByDesc('completions');
		return $this->addRankingParameter($provinces,'completions');
	}

	/**
    * Gets all communidads ordered by number of completions
    *
    * @return eloquent collection of communidads ordered by number of completions
    */

	public function getCommunidadsOrderedByCompletions()
	{

		$communidads = Communidad::all();
		$communidads->map(function($item){
			$item->completions = count($this->getAllCimerosWhoHaveCompletedAnArea('communidad_id',$item->id));
			return $item;
		})->sortByDesc('completions');

		$communidads = $communidads->sortByDesc('completions');
		return $this->addRankingParameter($communidads,'completions');
	}

	/**
    * Gets all cimeros ordered by number of completed provinces
    *
    * @return eloquent collection of communidads ordered by completed provinces
    */

	public function getCimerosOrderByCompletedProvinces()
	{
		$cimeros = $this->getCimerosOrderedByCompletedProvincesOrCommunidads("provincia_id");
		$cimeros->transform(function($item){
			$cimero = Cimero::find($item->cimero_id);
			$cimero->nombre = $cimero->getFullName();
			$cimero->count = $item->count;
			return $cimero;
		});
		
		$cimeros = $cimeros->sortByDesc('count');
		return $this->addRankingParameter($cimeros, 'count');
	}

	/**
    * Gets all cimeros ordered by number of completed communidads
    *
    * @return eloquent collection of cimeros ordered by completed communidads
    */

	public function getCimerosOrderByCompletedCommunidads()
	{
		$cimeros = $this->getCimerosOrderedByCompletedProvincesOrCommunidads("communidad_id");
		$cimeros->transform(function($item){
			$cimero = Cimero::find($item->cimero_id);
			$cimero->nombre = $cimero->getFullName();
			$cimero->count = $item->count;
			return $cimero;
		});
		
		$cimeros = $cimeros->sortByDesc('count');
		return $this->addRankingParameter($cimeros, 'count');
	}

	/**
    * Gets DB object of cimeros ordered by completed areas defined by a foreign key. Returns count and cimero_id
    *
    * @param string $foreign_key provincia_id, communidad_id
    * @return eloquent collection 
    */

	public function getCimerosOrderedByCompletedProvincesOrCommunidads($foreign_key)
	{
		$rawQuery = "select t.cimero_id as cimero_id, count(t.".$foreign_key.") as count from (SELECT cimas.".$foreign_key." as ".$foreign_key.", logros.cimero_id as cimero_id, count(distinct cimas.id) as cimas_count, count(distinct logros.cima_codigo) as logros_count FROM cimas left join logros on cimas.".$foreign_key." = logros.".$foreign_key." where cimas.estado = 1 group by cimas.".$foreign_key.", logros.cimero_id order by logros.cimero_id) as t where t.cimas_count = t.logros_count group by t.cimero_id;";
		return collect(DB::select($rawQuery));
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

