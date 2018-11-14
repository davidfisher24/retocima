<?php

namespace App\Services;

use DB;

use App\Cimero;
use App\Cima;
use App\Logro;


class CimeroLogroService extends BaseService
{

    public function __construct() {}


    /**
     * Validates and saved an array of logros
     *
     * @param array $logros (ids)
     * @param intger $cimeroId
     * @return collection cimas successfully added
     *
     */

     public function validateAndAddNewLogros($logros,$cimeroId)
    {
        $addedLogros = array();

        foreach ($logros as $l) {
            $l = (integer) $l;
            $alreadyIncluded = $this->checkCimeroLogro($cimeroId,$l);

            if(!$alreadyIncluded) {
                $cima = Cima::find($l);
                $logro = new Logro();
                $logro->cimero_id = $cimeroId;
                $logro->cima_id = $cima->id;
                $logro->cima_codigo = $cima->codigo;
                $logro->cima_estado = $cima->estado;
                $logro->provincia_id = $cima->provincia_id;
                $logro->communidad_id = $cima->communidad_id;
                $logro->iberia_id = $cima->iberia_id;

                $logro->save();
                array_push($addedLogros,$logro);
            }
        }

        return $addedLogros;
    }

    /**
     * Removes a single logro
     *
     * @param {object} logro
     * @return {mixed} check for deletion
     */

    public function removeExistingLogro($logro){
        Logro::destroy($logro->id);
        $check = $this->checkCimeroLogro($logro->cimero_id,$logro->cima_id);
        return !!$check;
    }

    /**
     * Tests if a logro exists
     *
     * @param {integer} cimeroId
     * @param (integer) logroId
     * @return {boolean} 
     */

    private function checkCimeroLogro ($cimeroId,$logroId) {
        $check = Cimero::find($cimeroId)->logros->where('cima_id',$logroId)->count();
        if ($check === 1) return true;
        return false;
    }
    
}