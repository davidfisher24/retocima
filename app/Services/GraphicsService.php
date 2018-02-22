<?php

namespace App\Services;


class GraphicsService
{

	public function barChart($data,$labelKey,$datakey,$title)
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

    public function pieChart($data,$labelKey,$datakey,$title)
    {
        $chartData = array();
        foreach ($data as $datum) {
            array_push($chartData,array(
                $datum[$labelKey],
                $datum[$datakey],
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
            "text" => $title,
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
                "name" => "Asenciones",
                "data" => $chartData,
            )
        );

        return $chartArray;

    }

    public function splineChart($data,$labelKey,$datakey,$title)
    {
        $xLabels = array();
        $seris = array();

        foreach ($data as $datum) {
            array_push($xLabels,$datum[$labelKey]);
            array_push($seris,$datum[$datakey]);
        }

        $chartArray ["chart"] = array (
            "type" => "spline" 
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
            "labels" => false,
            /*"labels" => array (
                "rotation" => -45,
                "style" => array(
                    "fontSize" => '13px',
                    "fontFamily" => 'Verdana, sans-serif'
                )
            )*/
        );
        $chartArray ["yAxis"] = array (
            "allowDecimals" => false,
            "min" => 0,
            "max" => max($seris),
            "title" => array(
                "text" => "Altitud",
            ),
        );
        $chartArray ["legend"] = array(
            "enabled" => false,
        );
        $chartArray ["series"] = array(
            array(
                "name" => "Altitud",
                "data" => $seris 
            ),
        );

        return $chartArray;
    }

}

