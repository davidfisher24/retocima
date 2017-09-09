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
        	/*Mapper::marker($cima->longitude, $cima->latitude, [
        		'eventClick' => $clickEvent,
        	]);*/

            $contentString = '<p class="panel-heading"><strong>'. $cima->codigo . ' ' . $cima->nombre . '</strong></p>';
            $contentString .= '<a href="/detallescima/' . $cima->id . '" target="_BLANK">Mas Detalles</a>';
        	Mapper::informationWindow($cima->longitude, $cima->latitude, $contentString, [
        		'open' => false, 
        		'maxWidth'=> 300, 
        		'markers' => ['title' => 'Title'],
        		'eventClick' => $clickEvent,
        	]);
        }
        



        
        
        return view('publicarea.mapa');
    }
}
