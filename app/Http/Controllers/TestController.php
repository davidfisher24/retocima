<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cima;
use App\Services\MapService;
use App\Services\GraphicsService;
use App\Services\ProvinciaLogroService;
use App\Services\CommunidadLogroService;

class TestController extends Controller
{
    public function __construct(MapService $mapService, GraphicsService $graphicsService, CommunidadLogroService $communidadLogroService)
    {
        $this->mapService = $mapService;
        $this->graphicsService = $graphicsService;
        $this->communidadLogroService = $communidadLogroService;
    }

    public function showTestPage()
    {   

        $data = $this->communidadLogroService->getAllCommunidadsRankedByLogros()->map(function($comm){
            return array($comm->nombre,$comm->logros_count);
        });

        $xLabels = array();
        $seris = array();
        foreach ($data as $datum) {
            array_push($xLabels,$datum[0]);
            array_push($seris,array("name" => $datum[0], "data" => array($datum[1])));
        }


        $chartArray ["chart"] = array (
            "type" => "column" 
        );
        $chartArray ["title"] = array (
            "text" => "Yearly sales" 
        );
        $chartArray ["credits"] = array (
            "enabled" => false 
        );
        $chartArray ["xAxis"] = array (
            "type" => 'category',
            "labels" => array (
                "rotation" => -45,
                "style" => array(
                    "fontSize" => '13px',
                    "fontFamily" => 'Verdana, sans-serif'
                )
            )
        );
        $chartArray ["yAxis"] = array (
            "allowDecimals" => true,
            "min" => 0,
            "max" => 7000,
            "title" => array(
                "text" => "Ascensiones",
            ),
        );
        $chartArray ["legend"] = array(
            "enabled" => false,
        );
        $chartArray ["series"] = $seris;


        
        return view('testarea.test')->withChartarray ( $chartArray );
    }
}
