<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\PataNegraService;
use App\Services\MapService;

class PataNegraController extends Controller
{
	public function __construct(PataNegraService $pataNegraService, MapService $mapService)
    {
        $this->pataNegraService = $pataNegraService;
        $this->mapService = $mapService;
    }

    public function showInitialPataNegraPage()
    {
    	$cimas = $this->pataNegraService->getPataNegraCimas();
        $map = $this->mapService->makeBasicCimasMap($cimas, $settings = array("cluster" => false));
        return view('publicarea.patanegra', compact('cimas'));
    }
}
