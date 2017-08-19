<?php

namespace App\Repositories;

use DB;

use App\Logro;

class LogroRepository 
{
	public function getLogrosByCimeroId($cimeroId)
	{
		return Logro::with('cima','provincia','communidad')->where('cimero_id',$cimeroId)->get()->groupBy('communidad_id')->map(function($item){
			return $item->groupBy('provincia_id')->keyBy($item->first()->first()->communidad->nombre);
		});
	}
}
