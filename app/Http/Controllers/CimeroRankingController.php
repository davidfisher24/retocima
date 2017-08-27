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

    public function displayRankingPage()
    {
        return view('publicarea.ranking');
    }

    /**
     * Return array of all cimeros ranking, and a column structure for the table.
     *
     * @return array Table Data
     */

    public function baseRanking()
    {

    	$cimeros = $this->cimeroLogroService->getRankingOfAllCimeros();
        
        $columns = array(
            array("field" => 'ranking', "title" => ''),
            array("field" => 'id', "title" => 'No. Cimero'),
            array("field" => 'nombre', "title" => 'Nombre'),
            array("field" => 'provincia', "title" => 'Provincia'),
            array("field" => 'logros_count', "title" => 'Logros'),
        );
        
        return array(
            "dataObject" => $cimeros->flatten(),
            "columns" =>  $columns,
            "filters" => ['provincia'],
        );
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
