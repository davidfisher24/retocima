<?php

namespace App\Repositories;

use DB;

use App\Logro;

class LogroRepository 
{
	protected $model;

	/**
    * Set class to injected model
    * 
    * @param Model $logro
    * @return void
    */

	public function __construct(Logro $model) {
	  $this->model = $model;
	}

	/**
     * Get all logros by a cimero id
     *
     * @param Integer $cimeroId
     * @return Eloquent collection
     */


	public function getLogrosByCimeroId($cimeroId)
	{
		return $this->model->with('cima','provincia','communidad')->where('cimero_id',$cimeroId)->get();
	}

	/**
     * counts number of logros in groups by a foreign key
     *
     * @param string $foreign_key (cimero_id,cima_id,provincia_id,communidad_id,iberia_id)
     *
     * @return collection foreign keys ids with logros count
     */

	public function countLogrosByAForeignKey($foreign_key, $filter = null)
    {
        $filteredModel = $this->model;
        if ($filter) $filteredModel = $this->model->where($filter["key"],$filter["id"]);
        return $filteredModel->select($foreign_key,DB::raw('count(*) as logros_count'))->groupBy($foreign_key)->get()->sortByDesc('logros_count');
    }

    /**
     * returns all logros grouped by two foreign_keys (only the foreign_keys are returned)
     *
     * @param string $foreign_key_1 (cimero_id,cima_id,provincia_id,communidad_id,iberia_id)
     * @param string $foreign_key_2 (cimero_id,cima_id,provincia_id,communidad_id,iberia_id)
     *
     * @return collection
     */

    public function getLogrosGroupedByTwoForeignKeys($foreign_key_1,$foreign_key_2)
    {
        return $this->model->select($foreign_key_1,$foreign_key_2)->groupBy($foreign_key_1,$foreign_key_2)->get();
    }

}
