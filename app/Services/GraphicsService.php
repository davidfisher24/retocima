<?php

namespace App\Services;


class GraphicsService
{

	public function cimeroBarChart($data,$labelKey,$datakey,$title)
    {
        $xLabels = array();
        $seris = array();

        foreach ($data as $datum) {
            array_push($xLabels,$datum[$labelKey]);
            array_push($seris,$datum[$datakey]);
        }

        $chartArray ["chart"] = array (
            "type" => "column" 
        );
        $chartArray ["title"] = array (
            "text" => $title
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
            "allowDecimals" => false,
            "min" => 0,
            "max" => max($seris),
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


}

