<?php

namespace App\Services;

use App\Cimero;
use App\Cima;
use App\Logro;

class CimeroLogroService 
{

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
    	})->sortBy('provincia_id');

    	return $logros;
	}
}