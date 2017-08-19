<?php

namespace App\Services;

use App\Cimero;
use App\Cima;
use App\Logro;

use App\Repositories\LogroRepository;

class CimeroLogroService 
{

    /**
    * Loads $logroRepository Classes
    * 
    * @param repository $logroRepository
    *
    * @return void
    */


    public function __construct(LogroRepository $logroRepository)
    {
       $this->logroRepository = $logroRepository;
    }


	/**
     * Returns all logro_ids for a cimero
     *
     * @param integer $cimeroId
     * @return array cimero logro ids
     *
     */

	public function getCimeroLogrosCimaIds($id)
	{
		return Cimero::find($id)->logros()->get()->pluck('cima_id')->toArray();

	}

	/**
     * Returns all logros with details for a cimero
     *
     * @param integer $cimeroId
     *
     * @return collection cimero logros with cima details
     *
     */

	public function getCimeroWithDetailedLogros($id)
	{
    	$logros = Cimero::find($id)->logros()->get()->map(function($item, $index){
    		return Cima::find($item->cima_id);
    	});

    	return $logros;
	}

    /**
     * Returns all a cimeros logro in nested array of communidads
     *
     * @param integer $cimeroId
     *
     * @return collection cimero logros by communidad
     *
     */

    public function getCimeroLogrosGroupedByCommunidad($cimeroId){
        return $this->logroRepository->getLogrosByCimeroId($cimeroId)->groupBy('communidad_id')->map(function($item){
            return $item->groupBy('communidad_id','provincia_id')->keyBy($item->first()->first()->communidad->nombre);
        });
    }
}