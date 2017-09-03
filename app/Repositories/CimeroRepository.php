<?php

namespace App\Repositories;

use DB;
use App\Cimero;


class CimeroRepository 
{

     protected $model;

     /**
    * Set class to injected model
    * 
    * @param Model $cimero
    * @return void
    */

     public function __construct(Cimero $model) {
       $this->model = $model;
     }

	/**
     * A single cimero by id
     *
     * @param integer $id
     * @return Eloquent model cimero
     */

	public function getCimeroById($id){
		return $this->model->find($id);
	}

}