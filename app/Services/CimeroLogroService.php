<?php

namespace App\Services;

use DB;

use App\Cimero;
use App\Cima;
use App\Logro;

use App\Repositories\LogroRepository;

class CimeroLogroService extends BaseService
{

    /**
    * Loads $logroRepository Classes
    * 
    * @param repository $logroRepository
    *
    * @return void
    */


    public function __construct(LogroRepository $logroRepository)
    {
       $this->logroRepository = $logroRepository;
    }


	/**
     * Returns all logro_ids for a cimero
     *
     * @param integer $cimeroId
     * @return array cimero logro ids
     *
     */

	public function getCimeroLogrosCimaIds($id)
	{
		return Cimero::find($id)->logros()->get()->pluck('cima_id')->toArray();

	}

    private function getCimeroLogros($id)
    {
        return Cimero::find($id)->logros()->get();
    }

	/**
     * Returns all logros with details for a cimero
     *
     * @param integer $cimeroId
     *
     * @return collection cimero logros with cima details
     *
     */

	public function getCimeroWithDetailedLogros($id)
	{
    	$logros = Cimero::find($id)->logros()->get()->map(function($item, $index){
    		return Cima::find($item->cima_id);
    	});

    	return $logros;
	}

    public function getCimeroProvinciaCount($id) {
        return $this->getCimeroLogros($id)->groupBy('provincia_id')->map(function ($item, $key) {
            return array(
                "provincia" => $item->first()->provincia->nombre,
                "count" => $item->count()
            );
        })->sortByDesc('count');
    }

    /**
     * Returns all cimeros ranked by numero of logros
     *
     * @param array $filter a key to filter on (foreign_key, id)
     *
     * @return collection cimeros ranked by logros
     */

    public function getRankingOfAllCimeros($filter = null){

        $cimeros = $this->logroRepository->countLogrosByAForeignKey('cimero_id',$filter)->map(function($item,$i){
            $cimero = $item->cimero()->first();
            $item->nombre = $cimero->getFullName();
            $item->provincia = $cimero->getProvincia();
            $item->id = $cimero->id;
            return $item;
        });

        $cimeros->sortByDesc('logros_count');
        return $this->addRankingParameter($cimeros,'logros_count');

    }

    /**
     * Returns all a cimeros logro in nested array of communidads
     *
     * @param integer $cimeroId
     *
     * @return collection cimero logros by communidad
     *
     */

    public function getCimeroLogrosGroupedByCommunidad($cimeroId){
        return $this->logroRepository->getLogrosByCimeroId($cimeroId)->groupBy('communidad_id')->map(function($item){
            return $item->groupBy('communidad_id','provincia_id')->keyBy($item->first()->first()->communidad->nombre);
        });
    }

    /**
     * Returns all cimeros ranked by number of provinces started
     *
     * @return collection cimeros ranked by number of provinces with one logro
     *
     */

    public function getCimerosWithProvinciasWithAtLeastOneLogro()
    {
        $cimeros = $this->logroRepository->getLogrosGroupedByTwoForeignKeys('cimero_id','provincia_id')->groupBy('cimero_id')->transform(function($item,$i){
            $item->first()->count = count($item);
            return $item->first();
        })->sortByDesc('count')->values()->map(function($item,$i){
            $cimero = $item->cimero;
            $item->id = $cimero->id;
            $item->nombre = $cimero->getFullName();
            return $item;
        });

        $cimeros->sortByDesc('count');
        return $this->addRankingParameter($cimeros,'count');
    }

    /**
     * Validates an array of logros to be saved and asks the logros repo to save them
     *
     * @param array $logros (ids)
     * @param intger $cimeroId
     * @return collection cimas successfully added
     *
     */

    public function validateAndAddNewLogros($logros,$cimeroId)
    {
        $addedLogros = array();

        foreach ($logros as $logro) {
            $logro = (integer) $logro;
            $alreadyIncluded = $this->validateLogroIsNotAlreadyIncludedForCimero($logro,$cimeroId);
            if(!$alreadyIncluded) {
                $this->logroRepository->saveNewLogro($cimeroId,Cima::find($logro));
                array_push($addedLogros,$logro);
            }
        }

        return $addedLogros;
    }

    /**
     * Validates that a user doesn't already have a logro included
     *
     * @param intger $logrosId
     * @param intger $cimeroId
     * @return boolean - does the user have the cima
     *
     */

    public function validateLogroIsNotAlreadyIncludedForCimero($logroId,$cimeroId)
    {
        $check = Cimero::find($cimeroId)->logros->where('cima_id',$logroId)->count();
        if ($check === 1) return true;
        return false;
    }

    /**
     * Test if a cimero has a logro
     *
     * @param integer $id
     * @param integer $cimaid
     * @return Eloquent model logro or null
     */

    public function testCimeroLogroExists($cimeroId,$cimaId){
        if (!$cimeroId) return null;
        return Cimero::find($cimeroId)->logros->where('cima_id',$cimaId)->first();
    }

    /**
     * Test if a cimero has a logro
     *
     * @param {integer} LogroId
     * @return {object or boolean} check
     */

    public function removeExistingLogro($logro){
        $this->logroRepository->removeSingleLogro($logro->id);
        $check = $this->testCimeroLogroExists($logro->cimero_id,$logro->cima_id);
        return $check;
    }

}