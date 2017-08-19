<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\CimaRepository;

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

    public function __construct(CimaRepository $cimaRepository)
    {
        $this->cimaRepository = $cimaRepository;
    }

    /**
     * Show the list of communidads with number of cimas.
     *
     * @return Blade View
     */

    public function listCimasByCommunidad()
    {
    	
    	$commList = $this->cimaRepository->getCommunidadListWithCimasCount();
        return view('publicarea.listadocommunidads',compact('commList'));
    }

    /**
     * Show the list of provincias with number of cimas.
     *
     * @return Blade View
     */

    public function listCimasByProvincia($communidadId, $provinciaId = null)
    {


        $commList = Communidad::orderBy('nombre')->get();
        $provList = $this->cimaRepository->getprovinciaListWithCimasCount($communidadId);

        if (!$provinciaId) $provinciaId = Provincia::where('communidad_id',$communidadId)->orderBy('nombre')->first()->id;
        $cimaList = $this->cimaRepository->getCimasInProvincia($provinciaId);

        $currentCommunidad = (integer) $communidadId;
        $currentProvincia = (integer) $provinciaId;
        
        return view('publicarea.listadoprovincias',compact('commList','provList','cimaList','currentCommunidad','currentProvincia'));
    }

    /**
     * Show a detaails of one cima with vertientess
     *
     * @return Blade View
     */


    public function showCimaDetails($cimaId)
    {
        $cima = $this->cimaRepository->getCimaById($cimaId);
        return view('publicarea.detallescima',compact('cima'));
    }
}
