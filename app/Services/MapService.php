<?php

namespace App\Services;

use Mapper;

class MapService
{

	/**
    * Make a basic cluster nap of cimas passed
    *
    * @return collection
    */

    public function makeBasicCimasMap($cimas, $settings = array())
    {
        $defaults = array(
            'zoom' => 6, 'lat' => 40.416775, 'lng' => -3.703790, 'cluster' => true,
        );
        foreach($settings as $key => $setting) $defaults[$key] = $setting;

    	Mapper::map($defaults['lat'], $defaults['lng'] , ['zoom' => $defaults['zoom'], 'cluster' => $defaults['cluster'], 'marker' => []]);
        
        foreach($cimas as $cima) {
            if ($cima->latitude && $cima->longitude) {
                $clickEvent = 'mouseClickCima(' . $cima . ')';
                //$clickEvent = null;
                $contentString = '<p class="panel-heading"><strong>'. $cima->codigo . ' ' . $cima->nombre . '</strong></p>';
                $contentString .= '<a href="./detallescima/' . $cima->id . '" target="_BLANK">Mas Detalles</a>';
                Mapper::informationWindow($cima->longitude, $cima->latitude, $contentString, [
                    'open' => false, 
                    'maxWidth'=> 300, 
                    'markers' => ['title' => 'Title'],
                    'eventClick' => $clickEvent,
                ]);
            }
            
        }
    }

    

}

