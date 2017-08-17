<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\CimeroRankingService;

class CimeroStatisticsController extends Controller
{
    /**
     * Show a ranking of all cimero.
     *
     * @return Blade View
     */

    public function baseRanking()
    {
    	
    	$service = new CimeroRankingService();
    	$cimeros = $service->getRankingOfAllCimeros();
        return view('publicarea.ranking',compact('cimeros'));
    }


}
