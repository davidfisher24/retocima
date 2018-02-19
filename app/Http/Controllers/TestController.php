<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cima;
use App\Cimero;
use App\Provincia;
use App\Services\MapService;
use App\Services\GraphicsService;
use App\Services\ProvinciaLogroService;
use App\Services\CommunidadLogroService;
use App\Services\PataNegraService;
use App\Services\RecommenderService;

class TestController extends Controller
{
    public function __construct(MapService $mapService, GraphicsService $graphicsService, CommunidadLogroService $communidadLogroService, PataNegraService $pataNegraService, RecommenderService $recommenderService)
    {
        $this->mapService = $mapService;
        $this->graphicsService = $graphicsService;
        $this->communidadLogroService = $communidadLogroService;
        $this->pataNegraService = $pataNegraService;
        $this->recommenderService = $recommenderService;
    }

    public function showTestPage()
    {
        //return $this->recommenderService->createLogrosDictionary();
        return $this->recommenderService->buildRecommendationIndex(1060);
    }

    public function showCharts()
    {   

        

        $charts = array(
            $this->getBarChart(),
            $this->getPieChart(),
            $this->getCimerosChart(),
        );
        
        return view('testarea.test',compact('pataNegras'))->withChartarray ( $charts );
    }

    private function getBarChart()
    {
        $data = $this->communidadLogroService->getAllCommunidadsRankedByLogros()->map(function($comm){
            return array($comm->nombre,$comm->logros_count);
        });

        $xLabels = array();
        $seris = array();
        foreach ($data as $datum) {
            array_push($xLabels,$datum[0]);
            array_push($seris,$datum[1]);
        }


        $chartArray ["chart"] = array (
            "type" => "column" 
        );
        $chartArray ["title"] = array (
            "text" => "Total Ascensiones por Communidad" 
        );
        $chartArray ["credits"] = array (
            "enabled" => false 
        );
        $chartArray ["xAxis"] = array (
            "categories" => $xLabels,
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
        $chartArray ["series"] = array(
            array(
                "name" => "Total Ascensiones",
                "data" => $seris
            ),
        );

        return $chartArray;
    }

    private function getPieChart()
    {

        $chartData = array();
        $data = $this->pataNegraService->getPataNegrasRankedByAscensions();
        foreach ($data as $datum) {
            array_push($chartData,array(
                $datum["cima"]->nombre . " (" . $datum["cima"]->provincia . ")",
                $datum["ascensions"],
            ));
        }

        $chartArray ["chart"] = array (
            "type" => "pie",
            "options3d" => array(
                "enabled" => true,
                "alpha" => 45,
                "beta" => 0,
            ), 
        );

        $chartArray ["title"] = array (
            "text" => "Pata Negras por Ascensiones" 
        );
        $chartArray ["credits"] = array (
            "enabled" => false 
        );

        $chartArray ["plotOptions"] = array (
            "pie" => array (
                "allowPointSelect" => true,
                "cursor" => "pointer",
                "depth" => 35,
                "dataLabels" => array(
                    "enabled" => true,
                    "format" => "{point.name}"
                ),  
            ),
        );

        $chartArray ["series"] = array(
            array(
                "type" => "pie",
                "name" => "Pata Negra Por Asenciones",
                "data" => $chartData,
            )
        );

        return $chartArray;

    }


    private function getCimerosChart()
    {
        $cimeros = Cimero::with('logros')->get()->groupBy('provincia')->map(function($group){
            $logrosCount = 0;
            $name = $group->first()->provincia ? Provincia::find($group->first()->provincia)->nombre : "Extranjero";
            foreach($group as $person) $logrosCount = $logrosCount += count($person->logros);
            return array(
                "province" => $group->first()->provincia ? $group->first()->provincia : 0,
                "name" => $name,
                "logros" => $logrosCount,
                "cimeros" => count($group),
                "average" => round($logrosCount / count($group)),
            );
        });
        //die(print_r($cimeros->first()));
        //Array ( [province] => 17 [name] => Cantabria [logros] => 1586 [cimeros] => 48 [average] => 33.041666666667 ) 1
        $xLabels = array();
        $seris = array();
        $seris2 = array();
        $pieData = array();

        foreach ($cimeros as $cimero) {
            array_push($xLabels,$cimero["name"]);
            array_push($seris,$cimero["average"]);
            array_push($seris2,$cimero["logros"] / 50);
            array_push($pieData,array("name" => $cimero["name"], "y" => $cimero["cimeros"]));
        }

        $chartArray ["chart"] = array (
            "type" => "Combination chart" 
        );
        $chartArray ["title"] = array (
            "text" => "Provincias con cimeros mas activas" 
        );
        $chartArray ["credits"] = array (
            "enabled" => false 
        );
        $chartArray ["xAxis"] = array (
            "categories" => $xLabels,
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
            "title" => array(
                "text" => "Avg logros por cimero",
            ),
        );
        $chartArray ["legend"] = array(
            "enabled" => false,
        );
        $chartArray ["series"] = array(
            array(
                "name" => "Average Ascensiones",
                "type" => "column",
                "data" => $seris
            ),
            array(
                "name" => "Total Ascensiones",
                "type" => "spline",
                "data" => $seris2,
                "marker" => array(
                    "lineWidth" => 2,
                    "lineColor" => "red",
                    "fillColor" => "white",
                ),
                "tooltip" => array(),
            ),
            array(
                "name" => "Cimeros",
                "type" => "pie",
                "center" => array(900, 35),
                "size" => 200,
                "showInLegend" => false,
                "dataLabels" => array(
                    "enabled" => false,
                ),
                "data" => $pieData,
            ),
        );

        return $chartArray;
    }
}


        
