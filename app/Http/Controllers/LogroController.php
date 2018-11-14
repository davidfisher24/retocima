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

    public function cimaAction($cimaId)
    {
        return Logro::join('cimeros', 'cimeros.id', '=', 'logros.cimero_id')
                ->select(
                    'logros.id',
                    DB::raw(
                        'CONCAT(cimeros.nombre," ",cimeros.apellido1," ",cimeros.apellido2) as fullname'
                    )
                )
                ->where('cima_id',$cimaId)->get()->toJSON();
    }

    public function provinceStatisticsAction($provinceId)
    {
        return DB::table('logros')
                 ->select('cimero_id', DB::raw('count(*) as count'))
                 ->where('provincia_id',$provinceId)
                 ->groupBy('cimero_id')
                 ->orderByDesc('count')
                 ->get();
    }



}
