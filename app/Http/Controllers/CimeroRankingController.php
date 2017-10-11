<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\CimeroLogroService;
use App\Services\AreaCompletionService;

use App\Cimero;
use App\Communidad;

use Khill\Lavacharts\Lavacharts;

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

    public function __construct(CimeroLogroService $cimeroLogroService, AreaCompletionService $areaCompletionService)
    {
        $this->cimeroLogroService = $cimeroLogroService;
        $this->areaCompletionService = $areaCompletionService;
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
        $completions = $this->areaCompletionService->getCImerosCompletedProvincesAndCommunidads($id,$provincesGrouped = true);

        $completedProvinces = $this->areaCompletionService->getCimerosCompletedProvinces($id);
        $completedCommunidads = $this->areaCompletionService->getCimerosCompletedCommunidads($id);


        // CHART TO PUT IN A SERVICE
        $lava = new Lavacharts;

        $logrosChart = $lava->DataTable();

        $logrosChart->addStringColumn('Communidad')
                ->addNumberColumn('Logros');

        // DATA
        $logrosCountChart2 = array();
        foreach($logros as $comm) {
            $logrosChart->addRow([$comm->first()->first()->communidad->nombre,count($comm->first())]);
            $logrosCountChart2[$comm->first()->first()->communidad->id] = count($comm->first());
        }
        // END DATA

        $lava->PieChart('chart_1', $logrosChart, [
            'title'  => 'Logros Por Provincia',
            'is3D'   => true,
            'legend' => array( 'position' => 'left'),
        ]);
        // END CHART BLCOCK -> HAVE TO ADD AS A VIEW PARARM

        // SECOND CHART

        $percentCompleteChart = $lava->DataTable();

        $percentCompleteChart->addStringColumn('Communidad')
             ->addNumberColumn('Mis Logros')
             ->addNumberColumn('Total Cimas');

        // DATA
        foreach(Communidad::all() as $communidad) {
            $percentCompleteChart->addRow([
                $communidad->nombre, 
                array_key_exists($communidad->id,$logrosCountChart2) ? $logrosCountChart2[$communidad->id] : 0, 
                $communidad->cimas()->count()
            ]);
        }
        // END DATA
        $lava->ColumnChart('chart_2', $percentCompleteChart, [
            'title' => 'Mis Logros comparadao con total',
            'titleTextStyle' => [
                'color'    => '#eb6b2c',
                'fontSize' => 14
            ]
        ]);
        // END SECOND CHART BLCOCK -> HAVE TO ADD AS A VIEW PARARM
        

        return view('publicarea.cimeropublicdetails',compact('cimero','logros','completions','completedProvinces','completedCommunidads','lava'));

    }


}
