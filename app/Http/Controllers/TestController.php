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
        /*$data = $this->communidadLogroService->getAllCommunidadsRankedByLogros()->map(function($prov){
            return array($prov->nombre,$prov->logros_count);
        });

        $lava = $this->graphicsService->makePieChart('chart',"X Data","Y Data","Example Data",$data);
        return view('testarea.test',compact('lava'));*/

        $data = $this->communidadLogroService->getAllCommunidadsRankedByLogros()->map(function($comm){
            return array($comm->nombre,$comm->logros_count);
        });

        $lava = $this->graphicsService->makeBarChart('chart',"X Data","Y Data","Example Data",$data);
        return view('testarea.test',compact('lava'));
    }
}
