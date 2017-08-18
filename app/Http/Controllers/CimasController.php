<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\CimaRepository;

use App\Provincia;
use App\Communidad;

class CimasController extends Controller
{
    /**
     * Show the list of communidads with number of cimas.
     *
     * @return Blade View
     */

    public function listCimasByCommunidad()
    {
    	
    	$repo = new CimaRepository();
    	$commList = $repo->getCommunidadListWithCimasCount();
        return view('publicarea.listadocommunidads',compact('commList'));
    }

    /**
     * Show the list of provincias with number of cimas.
     *
     * @return Blade View
     */

    public function listCimasByProvincia($communidadId, $provinciaId = null)
    {

        $repo = new CimaRepository();

        $commList = Communidad::orderBy('nombre')->get();
        $provList = $repo->getprovinciaListWithCimasCount($communidadId);

        if (!$provinciaId) $provinciaId = Provincia::where('communidad_id',$communidadId)->orderBy('nombre')->first()->id;
        $cimaList = $repo->getCimasInProvincia($provinciaId);

        $currentCommunidad = (integer) $communidadId;
        $currentProvincia = (integer) $provinciaId;
        
        return view('publicarea.listadoprovincias',compact('commList','provList','cimaList','currentCommunidad','currentProvincia'));
    }

    public function showCimaDetails($cimaId)
    {
        $repo = new CimaRepository();
        $cima = $repo->getCimaById($cimaId);
        return view('publicarea.detallescima',compact('cima'));
    }
}
