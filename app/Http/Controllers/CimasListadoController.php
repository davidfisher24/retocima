<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

use App\Repositories\CimaRepository;
use App\Services\CimeroLogroService;

use App\Cima;
use App\Provincia;
use App\Communidad;

class CimasListadoController extends Controller
{

    /**
    * Loads $cimaRespository Class
    * 
    * @param cimaRepository $cimaRepository
    * @return Cimas Controller
    */

    public function __construct(CimaRepository $cimaRepository, CimeroLogroService $cimeroLogroService)
    {
        $this->cimaRepository = $cimaRepository;
        $this->cimeroLogroService = $cimeroLogroService;
    }

    /**
     * Show the list of communidads with number of cimas.
     *
     * @return Blade View
     */

    public function listCimasByCommunidad()
    {
    	$cimas = Cima::orderBy('nombre','desc')->get();
        $communidads = Communidad::with('provincias','cimas')->get()->sortBy('nombre');
        return view('publicarea.listadocommunidads',compact('communidads','cimas'));
    }

    /**
     * Show the list of provincias with number of cimas.
     *
     * @return Blade View
     */

    public function listCimasByProvincia($communidadId, $provinciaId = null)
    {


        $commList = Communidad::orderBy('nombre')->get();
        $provList = Cima::where('communidad_id',$communidadId)->with('provincia','vertientes')->groupBy('provincia_id')->select('provincia_id',DB::raw('count(*) as total'))->get()->sortBy('provincia');

        if (!$provinciaId) $provinciaId = Provincia::where('communidad_id',$communidadId)->orderBy('nombre')->first()->id;
        $cimaList = $this->cimaRepository->getCimasInProvincia($provinciaId)->sortBy('codigo');

        $currentCommunidad = (integer) $communidadId;
        $currentProvincia = (integer) $provinciaId;
        
        return view('publicarea.listadoprovincias',compact('commList','provList','cimaList','currentCommunidad','currentProvincia'));
    }

    /**
     * Show a detaails of one cima with vertientes
     *
     * @return Blade View
     */


    public function showCimaDetails($cimaId)
    {
        $userLogro = $this->cimeroLogroService->testCimeroLogroExists(Auth::id(),$cimaId);
        $cima = $this->cimaRepository->getCimaById($cimaId);
        return view('publicarea.detallescima',compact('cima','userLogro'));
    }
}
