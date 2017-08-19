<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\CimeroRankingService;

use App\Repositories\LogroRepository;

use App\Cimero;
use App\Communidad;


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

    /**
     * Show a detailed public view of cimero logros
     *
     * @return Blade View
     */

    public function cimeroPublicDetails($id)
    {
        $repo = new LogroRepository();

        $cimero = Cimero::find($id);
        $logros = $repo->getLogrosByCimeroId($id);


        return view('publicarea.cimeropublicdetails',compact('cimero','logros'));

    }


}
