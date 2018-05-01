<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Logro;

class LogroController extends Controller
{


    public function __construct()
    {

    }

    public function provinceStatisticsAction($provinceId)
    {
        return DB::table('logros')
                 ->select('cimero_id', DB::raw('count(*) as total'))
                 ->where('provincia_id',$provinceId)
                 ->groupBy('cimero_id')
                 ->get();
    }



}
