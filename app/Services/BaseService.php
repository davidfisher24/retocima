<?php

namespace App\Services;

use DB;

use App\Logro;

class BaseService
{

    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    public function countLogros($foreign_key){
        return Logro::select($foreign_key,DB::raw('count(*) as logros_count'))->groupBy($foreign_key)->get()->sortByDesc('logros_count');
    }

}