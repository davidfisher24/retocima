<?php

namespace App\Services;

use DB;

use App\Cimero;
use App\Cima;
use App\Logro;



class PataNegraService
{

	/**
    * Get list of pata negra cimas
    *
    * @return collection
    */

    public function getPataNegraCimas()
    {
    	return Cima::where('pata_negra',1)->get();
    }

    /**
    * Get the ids of the pata negra cimas
    *
    * @return array
    */

    private function getPataNegraCimaIds()
    {
    	return Cima::select('id')->where('pata_negra',1)->get()->pluck('id')->toArray();
    }

    /**
    * Returns all cimeros ranked by number of pataNegras. Includes cimero model and all pata negra models and the count
    *
    * @return collection
    */

    public function getCimeroscountedByCompletedPataNegras()
	{
		$pataNegras = $this->getPataNegraCimaIds();

		return Logro::whereIn('cima_id',$pataNegras)->get()->groupBy('cimero_id')->map(function($item) use ($pataNegras) {
			return array(
				"cimero" => Cimero::find($item->first()->cimero_id), 
				"pata_negras" => count($item),
				"pata_negras_completed" => $item->all(),
			);
		})->sortByDesc('pata_negras');
	}

	/**
    * Returns all the pata negra cimas ranked by number of ascensions. Includes cima model and the count
    *
    * @return collection
    */

	public function getPataNegrasRankedByAscensions()
	{
		$pataNegras = $this->getPataNegraCimaIds();

		return Logro::whereIn('cima_id',$pataNegras)->get()->groupBy('cima_id')->map(function($item) use ($pataNegras) {
			return array(
				"cima" => Cima::find($item->first()->cima_id), 
				"ascensions" => count($item),
			);
		})->sortByDesc('ascensions');
	}

}

//$c = new App\Services\PataNegraService()
