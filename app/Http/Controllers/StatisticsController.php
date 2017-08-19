<?php

namespace App\Http\Controllers;

use App\Services\CimeroLogroService;
use App\Services\CimaLogroService;
use App\Services\ProvinciaLogroService;
use App\Services\CommunidadLogroService;

use Illuminate\Http\Request;

class StatisticsController extends Controller
{

	/**
    * Loads service lasses required
    * 
    * @param service $cimeroLogroService
    * @param service $cimaLogroService
    * @param service $provinciaLogroService
    *
    * @return void
    */

    public function __construct(CimeroLogroService $cimeroLogroService, CimaLogroService $cimaLogroService, ProvinciaLogroService $provinciaLogroService, CommunidadLogroService $communidadLogroService)
    {
        $this->cimeroLogroService = $cimeroLogroService;
        $this->cimaLogroService = $cimaLogroService;
        $this->provinciaLogroService = $provinciaLogroService;
        $this->communidadLogroService = $communidadLogroService;
    }

    /**
     * Show the statistics dashboard.
     *
     * @return Blade View
     */

    public function testView()
    {
    	// Cimeros with provinces started
    	/*$cimeros = $this->cimeroLogroService->getCimerosWithProvinciasWithAtLeastOneLogro();
        return view('publicarea.estadistica',compact('cimeros'));
        Blade<table class="table">
            <tr>
                <th>No. Cimero</th>
                <th>Nombre</th>
                <th>Provincias</th>
            </tr>
            <tbody>
            @foreach ($cimeros as $cimero)
                <tr>
                <td>{{$cimero->id}}</td>
                <td>{{$cimero->nombre}}</td>
                <td>{{$cimero->count}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>*/
       	
        
        // Cimas ranked by logros
        /*$cimas = $this->cimaLogroService->getAllCimasRankedByLogros();
        return view('publicarea.estadistica',compact('cimas'));
        Blade
        <table class="table">
            <tr>
                <th>Provincia</th>
                <th>Codigo y nombre</th>
                <th>Total</th>
            </tr>
            <tbody>
            @foreach ($cimas as $cima)
                <tr>
                <td>{{$cima->provincia}}</td>
                <td>{{$cima->codigo}}  {{$cima->nombre}}</td>
                <td>{{$cima->logros_count}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>*/

        // Provincias ranked by ascensions
        /*$provincias = $this->provinciaLogroService->getAllProvinciasRankedByLogros();
        return view('publicarea.estadistica',compact('provincias'));
        Blade
        <table class="table">
            <tr>
                <th>Provincia</th>
                <th>Total</th>
            </tr>
            <tbody>
            @foreach ($provincias as $provincia)
                <tr>
                <td>{{$provincia->nombre}}</td>
                <td>{{$provincia->logros_count}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>*/

        // Communidads ranked by ascensions
        /*$communidads = $this->communidadLogroService->getAllCommunidadsRankedByLogros();
        return view('publicarea.estadistica',compact('communidads'));
        blade
        <table class="table">
            <tr>
                <th>Communidad</th>
                <th>Total</th>
            </tr>
            <tbody>
            @foreach ($communidads as $communidad)
                <tr>
                <td>{{$communidad->nombre}}</td>
                <td>{{$communidad->logros_count}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>*/

        

        // Filtering cimeros by iberia/communidad/provincia which needs a filter passing
        /*$filter = array('key' => 'iberia_id', 'id' => 1);
        $cimeros = $this->cimeroLogroService->getRankingOfAllCimeros($filter = $filter);
        return view('publicarea.estadistica',compact('cimeros'));
        blade
        <table class="table">
	        <tr>
	            <th>No. Cimero</th>
	            <th>Nombre</th>
	            <th>Total</th>
	        </tr>
	        <tbody>
	        @foreach ($cimeros as $cimero)
	            <tr>
	            <td>{{$cimero->id}}</td>
	            <td>{{$cimero->nombre}}</td>
	            <td>{{$cimero->logros_count}}</td>
	            </tr>
	        @endforeach
	        </tbody>
        </table>*/

        return view('publicarea.estadistica');
    }
}
