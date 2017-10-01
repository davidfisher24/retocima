<?php

namespace App\Http\Controllers;


use App\Services\CimeroLogroService;
use App\Services\CimaLogroService;
use App\Services\ProvinciaLogroService;
use App\Services\CommunidadLogroService;
use App\Services\AreaCompletionService;

use Illuminate\Http\Request;


class StatisticsController extends Controller
{

	/**
    * Loads service lasses required
    * 
    * @param service $cimeroLogroService
    * @param service $cimaLogroService
    * @param service $provinciaLogroService
    *
    * @return void
    */

    public function __construct(CimeroLogroService $cimeroLogroService, CimaLogroService $cimaLogroService, ProvinciaLogroService $provinciaLogroService, CommunidadLogroService $communidadLogroService, AreaCompletionService $areaCompletionService)
    {
        $this->cimeroLogroService = $cimeroLogroService;
        $this->cimaLogroService = $cimaLogroService;
        $this->provinciaLogroService = $provinciaLogroService;
        $this->communidadLogroService = $communidadLogroService;
        $this->areaCompletionService = $areaCompletionService;
    }

    /**
     * Show the statistics dashboard.
     *
     * @return Blade View
     */


    public function showStatisticsHomePage()
    {
        return view('publicarea.estadistica');
    }

    
    /**
     * Returns provinces started statistics.
     *
     * @return Table object
     */
    
    public function getCimerosWithProvinciasWithAtLeastOneLogro()
    {
        return $this->cimeroLogroService->getCimerosWithProvinciasWithAtLeastOneLogro();
    }


    /**
     * Returns cima by ascensiones statistics.
     *
     * @return eloquent object
     */
    

    public function getAllCimasRankedByLogros()
    {
        return $this->cimaLogroService->getAllCimasRankedByLogros();
    }

    /**
     * Returns provinces by ascensiones.
     *
     * @return eloquent object
     */
    

    public function getAllProvinciasRankedByLogros()
    {
        return $this->provinciaLogroService->getAllProvinciasRankedByLogros();
    }

    /**
     * Returns communidads by acensiones statsitcs.
     *
     * @return eloquent object
     */
    

    public function getAllCommunidadsRankedByLogros()
    {
        return $this->communidadLogroService->getAllCommunidadsRankedByLogros();
    }

    /**
     * Returns cimeros ranking inside a province/communidad/iberia
     *
     * @param $request requests with keys and id filter
     * example  $filter = array('key' => 'communidad_id', 'id' => 16);
     *
     * @return eloquent object
     */
    

    public function getRankingOfAllCimeros($filter, $id)
    {
        $filter = array("key" => $filter, 'id' => $id);
        return $this->cimeroLogroService->getRankingOfAllCimeros($filter = $filter);
    }

    /**
     * Returns provinces by completion 
     *
     * @return eloquent object
     */

    public function getRankingOfProvincesByCompletion()
    {
        return $this->areaCompletionService->getProvincesOrderedByCompletions();
    }

    /**
     * Returns communidads by completions 
     *
     * @return eloquent object
     */

    public function getRankingOfCommunidadsByCompletion()
    {
        return $this->areaCompletionService->getCommunidadsOrderedByCompletions();
    }

    /**
     * Returns cimeros ranked by provinces completed
     *
     * @return eloquent object
     */

    public function getRankingOfCimerosByProvinciaCompletion()
    {
        return $this->areaCompletionService->getCimerosOrderByCompletedProvinces();
    }

    /**
     * Returns cimeros ranked by completed communidads
     *
     * @return eloquent object
     */

    public function getRankingOfCimerosByCommunidadCompletion()
    {
        return $this->areaCompletionService->getCimerosOrderByCompletedCommunidads();
    }  
  
   
}
