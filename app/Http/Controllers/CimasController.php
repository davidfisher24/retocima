<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\CimaRepository;

use App\Provincia;

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

    public function listCimasByProvincia($communidadId, $currentProv = null)
    {

        $repo = new CimaRepository();
        $provList = $repo->getprovinciaListWithCimasCount($communidadId);

        if (!$currentProv) $currentProv = Provincia::where('communidad_id',$communidadId)->orderBy('nombre')->first()->id;
        $cimaList = $repo->getCimasInProvincia($currentProv);
        
        return view('publicarea.listadoprovincias',compact('provList','cimaList','currentProv'));
    }
}
