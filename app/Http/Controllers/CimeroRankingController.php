<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\CimeroLogroService;

use App\Cimero;


class CimeroRankingController extends Controller
{

    /**
    * Loads $cimeroRankingService and $cimeroLogroService Classes
    * 
    * @param service $cimeroRankingService
    * @param service $cimeroLogroService
    *
    * @return void
    */

    public function __construct(CimeroLogroService $cimeroLogroService)
    {
        $this->cimeroLogroService = $cimeroLogroService;
    }

    /**
     * Show a ranking of all cimeros.
     *
     * @return Blade View
     */

    public function baseRanking()
    {

    	$cimeros = $this->cimeroLogroService->getRankingOfAllCimeros();
        //return view('publicarea.ranking',compact('cimeros'));
        return $cimeros->flatten()->toJson();
    }

    /**
     * Show a detailed public view of cimero logros
     *
     * @param intger $cimeroId
     * @return Blade View
     */

    public function cimeroPublicDetails($id)
    {

        $cimero = Cimero::find($id);
        $logros = $this->cimeroLogroService->getCimeroLogrosGroupedByCommunidad($id);

        return view('publicarea.cimeropublicdetails',compact('cimero','logros'));

    }


}
