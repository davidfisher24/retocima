<?php

namespace App\Services;

use DB;

use App\Cimero;
use App\Cima;
use App\Logro;

use App\Repositories\LogroRepository;

class CimaLogroService 
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
        return $this->logroRepository->countLogrosByAForeignKey('cima_id')->map(function($item,$i){
            $cima = $item->cima()->first();
            $item->ranking = $i + 1;
            $item->nombre = $cima->nombre;
            $item->codigo = $cima->codigo;
            $item->provincia = $cima->provincia;
            return $item;
        });
    }

}