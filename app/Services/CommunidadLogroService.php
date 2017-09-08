<?php

namespace App\Services;

use DB;

use App\Communidad;

use App\Repositories\LogroRepository;

class CommunidadLogroService extends BaseService
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
     * Returns all communidads ranked by number of logros
     *
     * @return collection provincias
     *
     */

    public function getAllCommunidadsRankedByLogros(){
        $communidads = $this->logroRepository->countLogrosByAForeignKey('communidad_id')->map(function($item){
            $communidad = $item->communidad()->first();
            $item->nombre = $communidad->nombre;
            return $item;
        });

        $communidads->sortByDesc('logros_count');
        return $this->addRankingParameter($communidads,'logros_count');
    }

}