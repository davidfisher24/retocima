<?php

namespace App\Services;

use DB;

use App\Cimero;
use App\Cima;
use App\Logro;

use App\Repositories\LogroRepository;

class CimaLogroService extends BaseService
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
     * Returns all a cimeros logro in nested array of communidads
     *
     *
     * @return collection cimero logros by communidad
     *
     */

    public function getAllCimasRankedByLogros(){
        $cimas = $this->logroRepository->countLogrosByAForeignKey('cima_id')->map(function($item){
            $cima = $item->cima()->first();
            $item->id = $cima->id;
            $item->nombre = $cima->nombre;
            $item->codigo = $cima->codigo;
            $item->provincia = $cima->provincia;
            return $item;
        });

        $cimas->sortByDesc('logros_count');
        return $this->addRankingParameter($cimas,'logros_count');
    }


    

}