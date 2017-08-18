<?php

namespace App\Repositories;

use DB;

use App\Cima;
use App\Communidad;
use App\Provincia;

class CimaRepository 
{
	/**
     * List of communidads with count of cimas in each
     *
     * @return Eloquent collection
     */


	public function getCommunidadListWithCimasCount(){
        return Cima::groupBy('communidad_id')->select('communidad_id',DB::raw('count(*) as total'))->with('communidad')->get()->sortBy('communidad');
	}

	/**
     * List of provincias with count of cimas in each
     *
     * @param integer $communidadId
     * @return Eloquent collection
     */

	public function getProvinciaListWithCimasCount($communidadId){
        return Cima::where('communidad_id',$communidadId)->with('provincia')->groupBy('provincia_id')->select('provincia_id',DB::raw('count(*) as total'))->get()->sortBy('provincia');
	}

	/**
     * A single cima by id
     *
     * @param integer $id
     * @return Eloquent model cima
     */

	public function getCimaById($id){
		return Cima::with('vertientes','provincia','communidad','iberia')->find(1);
	}

	/**
     * Get all cimas in a province
     *
     * @param integer $provinciaId
     * @return Eloquent collection
     */

	public function getCimasInProvincia($provinciaId){
		return Cima::where('provincia_id',$provinciaId)->get();
	}

	/**
     * Get all cimas in a communidad
     *
     * @param integer $communidad
     * @return Eloquent collection
     */


	public function getCimasInCommunidad($communidadId){
		return Cima::where('communidad_id',$communidadId)->get();
	}


}