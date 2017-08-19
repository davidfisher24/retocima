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
    * Loads $cimeroRankingService and $logroRepository Classes
    * 
    * @param service $cimeroRankingService
    * @param repository $logroRepository
    *
    * @return Cimero statistics Controller
    */

    public function __construct(CimeroRankingService $cimeroRankingService, LogroRepository $logroRepository)
    {
        $this->cimeroRankingService = $cimeroRankingService;
        $this->logroRepository = $logroRepository;
    }

    /**
     * Show a ranking of all cimero.
     *
     * @return Blade View
     */

    public function baseRanking()
    {

    	$cimeros = $this->cimeroRankingService->getRankingOfAllCimeros();
        return view('publicarea.ranking',compact('cimeros'));
    }

    /**
     * Show a detailed public view of cimero logros
     *
     * @return Blade View
     */

    public function cimeroPublicDetails($id)
    {

        $cimero = Cimero::find($id);
        $logros = $this->logroRepository->getLogrosByCimeroId($id);


        return view('publicarea.cimeropublicdetails',compact('cimero','logros'));

    }


}
