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

    public function validateAndAddNewLogro($logro,$cimeroId)
    {
        $logro = (integer) $logro;
        $cimero = Cimero::find($cimeroId);
        $cima = Cima::find($logro);

        // Check if is registered already or not
        if(!$this->checkCimeroLogro($cimeroId,$logro)) {
            $logro = new Logro();
            $logro->cimero_id = $cimeroId;
            $logro->cima_id = $cima->id;
            $logro->save();

            // Add a cimero logro if previous not completed
            if (!$cima->substitute || 
                ($cima->substitute && !$this->checkCimeroLogro($cimeroId,$cima->substitute))
            ) {
                $cimero->logro_count = $cimero->logro_count + 1;
                $cimero->save();
            }

            return $logro;
        }
        return null;
    }

    /**
     * Removes a single logro
     *
     * @param {object} logro
     * @return {mixed} check for deletion
     */

    public function removeExistingLogro($logro,$cimeroId){
        $cima = Cima::find($logro->cima_id);
        $cimero = Cimero::find($cimeroId);
        Logro::destroy($logro->id);
    
        // Remove a cimero logro if previous not completed
        if (!$cima->substitute ||
            $cima->substitute && !$this->checkCimeroLogro($cimeroId,$cima->substitute)
        ) {
            $cimero->logro_count = $cimero->logro_count - 1;
            $cimero->save();
        }

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

    /**
     * Gets all logros for a user
     *
     * @param {integer} cimero id
     * @return {array} logros
     */

    public function getLogros ($cimero) {
        return Logro::with(array('cima'=>function($query){
            $query->select('id','provincia_id','estado','codigo');
        }))->where('cimero_id',$cimero)->whereIn('cima_estado',array(1,2,3))->get();
    }

    /**
     * Gets all logros in a province for a user
     *
     * @param {integer} cimero id
     * @param {integer} province id
     * @return {array} logros
     */

    public function getLogrosInProvince ($cimero,$province) {
        /*return Logro::with(array('cima'=>function($query){
            $query->select('id','provincia_id','estado','codigo');
        }))
        ->where('cimero_id',$cimero)
        ->where('provincia_id',$province)
        ->whereIn('cima_estado',array(1,2,3))
        ->get();*/

        return Logro::with(array('cima'=>function($query){
            $query->select('id','provincia_id','estado','codigo');
        }))
        ->where('cimero_id',$cimero)
        ->whereHas('cima', function($q) use ($province) {
            $q->where('provincia_id',$province)->whereIn('estado',array(1,2,3));
        })
        ->get();
    }
    
}