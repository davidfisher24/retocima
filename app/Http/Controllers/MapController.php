<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mapper;
use App\Cima;
use App\Services\MapService;

class MapController extends Controller
{
    public function __construct(MapService $mapService)
    {
        $this->mapService = $mapService;
    }

    public function showInitialMapPage()
    {
    	$cimas = Cima::with('provincia','communidad','vertientes')->get();
        $map = $this->mapService->makeBasicCimasMap($cimas);
        return view('publicarea.mapa');
    }
}
