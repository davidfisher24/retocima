<?php

namespace App\Services;

use App\Cimero;
use App\Cima;
use App\Logro;

class CimeroLogroService extends BaseService
{


	public function getCimeroWithDetailedLogros($id){
    	$logros = Cimero::find($id)->logros()->get()->map(function($item, $index){
    		return Cima::find($item->cima_id);
    	})->sortBy('provincia_id');

    	return $logros;
	}
}