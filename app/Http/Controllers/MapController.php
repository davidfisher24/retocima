<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mapper;
use App\Cima;

class MapController extends Controller
{
    public function showInitialMapPage()
    {
    	$cimas = Cima::with('provincia','communidad','vertientes')->get();

        Mapper::map(40.416775, -3.703790, ['zoom' => 6, 'marker' => []]);
        foreach($cimas as $cima) {
        	$clickEvent = 'mouseClickCima(' . $cima . ')';
        	Mapper::marker($cima->longitude, $cima->latitude, [
        		'symbol' => 'circle', 
        		'scale' => 1000,  
        		'eventClick' => $clickEvent,
        	]);
        }
        



        
        
        return view('publicarea.mapa');
    }
}
