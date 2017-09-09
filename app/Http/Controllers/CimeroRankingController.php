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
    * Returns base page view
    * 
    * @return blade view
    */


    public function displayRankingPage()
    {
        return view('publicarea.ranking');
    }

    /**
     * Return all cimeros ranking.
     *
     * @return eloquent object
     */

    public function baseRanking()
    {

    	return $this->cimeroLogroService->getRankingOfAllCimeros();
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
