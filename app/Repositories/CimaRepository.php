<?php

namespace App\Repositories;

use DB;

use App\Cima;
use App\Communidad;
use App\Provincia;

class CimaRepository 
{

     protected $model;

     /**
    * Set class to injected model
    * 
    * @param Model $cima
    * @return void
    */

     public function __construct(Cima $model) {
       $this->model = $model;
     }

	/**
     * A single cima by id
     *
     * @param integer $id
     * @return Eloquent model cima
     */

	public function getCimaById($id){
		return $this->model->with('vertientes','vertientes.enlaces','provincia','communidad','iberia')->find($id);
	}

    /**
     * A single cima by id with statistics object
     *
     * @param integer $id
     * @return Eloquent model cima
     */

    public function getCimaByIdWithStatistics($id){
       return $this->model->with('vertientes','vertientes.enlaces','provincia','communidad','iberia','logros')->find($id);
    }

	/**
     * Get all cimas in a province
     *
     * @param integer $provinciaId
     * @return Eloquent collection
     */

	public function getCimasInProvincia($provinciaId){
		return $this->model->where('provincia_id',$provinciaId)->get();
	}

	/**
     * Get all cimas in a communidad
     *
     * @param integer $communidad
     * @return Eloquent collection
     */


	public function getCimasInCommunidad($communidadId){
		return $this->model->where('communidad_id',$communidadId)->get();
	}

    /**
     * Get all the pata negra cimas
     *
     * @return Eloquent collection
     */


    public function getPataNegraCimas(){
        return $this->model->where('pata_negra',true)->get();
    }



}