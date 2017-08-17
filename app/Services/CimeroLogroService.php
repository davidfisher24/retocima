<?php

namespace App\Services;

use App\Cimero;
use App\Cima;
use App\Logro;

class CimeroLogroService 
{

	/**
	 * Create a new service instance.
	 *
	 * @return void
	 */
    public function __construct($id)
    {
    	$this->cimeroId = $id;
    	
    }

	public function getCimeroWithDetailedLogros(){
    	$logros = Cimero::find($this->cimeroId)->logros()->get()->map(function($item, $index){
    		return Cima::find($item->cima_id);
    	})->sortBy('provincia_id');

    	return $logros;
	}
}