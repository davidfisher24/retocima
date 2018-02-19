<?php

namespace App\Services;

use App\Logro;
use App\Cima;
use App\Cimero;
use Storage;

class RecommenderService extends BaseService
{


    // Creates a logros dictionary
    public function createLogrosDictionary(){
        $dictionary = array();
        $cimas = array();
        $logros = Logro::all();

        foreach ($logros as $logro) {
            if (!in_array($logro->cima_id,$cimas)) array_push($cimas,$logro->cima_id);
            if (!array_key_exists($logro->cimero_id,$dictionary)) $dictionary[$logro->cimero_id] = array();
            $dictionary[$logro->cimero_id][$logro->cima_id] = 1;
        }

        $dictionary = $this->completeLogrosBinary($dictionary,$cimas);
        Storage::disk('local')->put('cimerosDictionary.json', json_encode($dictionary));
    }

    // Completes the binary in the logros
    private function completeLogrosBinary($dictionary,$cimas){
        foreach ($dictionary as $key => $row) {
            foreach ($cimas as $cima) {
                if (!array_key_exists($cima,$dictionary[$key])) $dictionary[$key][$cima] = 0;
            }
        }
        return $dictionary;
    }

    public function buildRecommendationIndex($cimaId){
        $dictionary = json_decode(Storage::get('cimerosDictionary.json'),true);
        $index = array();
        $cimeros = Cimero::all();
        $index = $this->getCimaRecommendations($cimaId);
        die(print_r($index));
        Storage::disk('local')->put('index/'+$cimaId+'.json', json_encode($index));
    }

    // Gets cima recommendations
    private function getCimaRecommendations($cimaId) {
        $dictionary = json_decode(Storage::get('cimerosDictionary.json'),true);
        $results = $this->findSimilarRows($dictionary,$cimaId);
        $ratings = $this->buildPredictionRatings($dictionary,$results,$cimaId);
        $cimas = array();
        for ($a=0; $a<20; $a++) {
            array_push($cimas,Cima::find($ratings[$a]["column"]));  
        }
        return $cimas;
    }

    private function buildPredictionRatings($dictionary,$similarRows,$rowA,$includeUser = false){
        $columns = array();
        $results = array();

        $similarRows = array_filter($similarRows,array($this,"test_positive"));

        foreach ($similarRows as $simRow) {
            foreach ($dictionary[$simRow["row"]] as $key => $row) {
                if (!$includeUser && $dictionary[$rowA][$key] === 0 || $includeUser) {

                    if (!array_key_exists($key, $columns)) {
                        $columns[$key] = array("calculatedRatings" => array(), "similarities" => array());
                    }

                    if (array_key_exists($key,$columns)) {
                        array_push($columns[$key]["calculatedRatings"], $dictionary[$simRow["row"]][$key] * $simRow["coefficient"]);
                        array_push($columns[$key]["similarities"], $simRow["coefficient"]);
                    }
                }
            }
        }

        foreach ($columns as $key => $col) {
            $result =  array_reduce($col["calculatedRatings"],array($this,"reduce_add")) / array_reduce($col["similarities"],array($this,"reduce_add"));
            array_push($results,array("column" => $key, "value" => $result));
        }

        usort($results, array($this,'sortByValue'));
        return $results;
    }


    private function findSimilarRows($dictionary,$rowA,$measure = "pearson"){
        $ranking = array();
        foreach ($dictionary as $key => $row) {
            $coefficient;
            if ($measure === "distance") $coefficient = $this->calculateDistance($dictionary[$rowA],$dictionary[$key]);
            else if ($measure === "pearson") $coefficient = $this->calculatePearson($dictionary[$rowA],$dictionary[$key]);
            if ($coefficient) array_push($ranking,array("row" => $key, "coefficient" => $coefficient));
        }
        usort($ranking, array($this,'sortByCoefficient'));;
        return $ranking;
    }

    private static function sortByCoefficient($a,$b) {
        if ($a['coefficient'] == $b['coefficient']) return 0;
        return ($b['coefficient'] < $a['coefficient']) ? -1 : 1;
    }

    private static function test_positive($var){
        return $var["coefficient"] >= 0;
    }

    private static function reduce_add($v1,$v2){
        return $v1 + $v2;
    }

    private static function sortByValue($a,$b) {
        if ($a['value'] == $b['value']) return 0;
        return ($b['value'] < $a['value']) ? -1 : 1;
    }

    private function calculatePearson($xObj,$yObj){
        $x = array();
        $y = array();

        foreach($xObj as $xKey => $xVal) {
            if (array_key_exists($xKey,$yObj)) {
                array_push($x,$xObj[$xKey]);
                array_push($y,$yObj[$xKey]);
            }
        }

        $length = count($x);
        if ($length === 0) return 0;

        $xy = array();
        $x2 = array();
        $y2 = array();

        for ($a = 0; $a < $length; $a++) {
            array_push($xy,$x[$a] * $y[$a]);
            array_push($x2,$x[$a] * $x[$a]);
            array_push($y2,$y[$a] * $y[$a]);
        }

        $sum_x = 0;
        $sum_y = 0;
        $sum_xy = 0;
        $sum_x2 = 0;
        $sum_y2 = 0;

        for ($b = 0; $b < $length; $b++) {
            $sum_x += $x[$b];
            $sum_y += $y[$b];
            $sum_xy += $xy[$b];
            $sum_x2 += $x2[$b];
            $sum_y2 += $y2[$b];
        }

        $step1 = ($length * $sum_xy) - ($sum_x * $sum_y);
        $step2 = ($length * $sum_x2) - ($sum_x * $sum_x);
        $step3 = ($length * $sum_y2) - ($sum_y * $sum_y);
        $step4 = sqrt($step2 * $step3);
        $answer = $step1/$step4;

        return $answer;

    }


}