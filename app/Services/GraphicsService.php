<?php

namespace App\Services;

use Khill\Lavacharts\Lavacharts;

class GraphicsService
{


    public function makePieChart($domId,$xTitle,$yTitle,$chartTitle,$data, $threeD = false, $legend = 'none')
    {
        $lava = new Lavacharts;
        $chart = $lava->DataTable();

        $chart->addStringColumn($xTitle)
                ->addNumberColumn($yTitle);

        foreach($data as $datum) {
            $chart->addRow([$data[0],$data[1]]);
        }

        $lava->PieChart($domId, $chart, [
            'title'  => $chartTitle,
            'is3D'   => $threeD,
            'legend' => array( 'position' => $legend),
        ]);
    }

    public function makeComboBarChart($domId,$xTitle,$yTitles,$chartTitle,$data)
    {
        $lava = new Lavacharts;
        $chart = $lava->DataTable();

        $chart->addStringColumn($xTitle);
        foreach ($yTitles as $yTitle) $chart->addNumberColumn($yTitle);

        foreach($data as $dataRow) {
            $chart->addRow($dataRow);
        }
        
        $lava->ColumnChart($domId, $chart, [
            'title' => $chartTitle,
            'titleTextStyle' => [
                'color'    => '#eb6b2c',
                'fontSize' => 14
            ]
        ]);
    }

}

