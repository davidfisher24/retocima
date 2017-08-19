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
		return $this->model->with('vertientes','provincia','communidad','iberia')->find($id);
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

    /**
     * List of communidads with count of cimas in each
     *
     * @return Eloquent collection
     */


    public function getCommunidadListWithCimasCount(){
        return $this->model->groupBy('communidad_id')->select('communidad_id',DB::raw('count(*) as total'))->with('communidad')->get()->sortBy('communidad');
    }

    /**
     * List of provincias with count of cimas in each
     *
     * @param integer $communidadId
     * @return Eloquent collection
     */

    public function getProvinciaListWithCimasCount($communidadId){
        return $this->model->where('communidad_id',$communidadId)->with('provincia')->groupBy('provincia_id')->select('provincia_id',DB::raw('count(*) as total'))->get()->sortBy('provincia');
    }



}