<?php

namespace App\Services;

use DB;

use App\Provincia;

use App\Repositories\LogroRepository;

class ProvinciaLogroService extends BaseService
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
     * Returns all provincias ranked by number of logros
     *
     * @return collection provincias
     *
     */

    public function getAllProvinciasRankedByLogros(){
        $provincias = $this->logroRepository->countLogrosByAForeignKey('provincia_id')->map(function($item){
            $provincia = $item->provincia()->first();
            $item->nombre = $provincia->nombre;
            return $item;
        });

        $provincias->sortByDesc('logros_count');
        return $this->addRankingParameter($provincias,'logros_count');
    }

}