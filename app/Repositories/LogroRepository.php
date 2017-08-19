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
		return $this->model->with('cima','provincia','communidad')->where('cimero_id',$cimeroId)->get()->groupBy('communidad_id')->map(function($item){
			return $item->groupBy('communidad_id','provincia_id')->keyBy($item->first()->first()->communidad->nombre);
		});
	}
}
