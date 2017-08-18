<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//use App\Services\CimasListService;
use App\Repositories\CimaRepository;

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

    public function listCimasByProvincia($communidadId)
    {
        $repo = new CimaRepository();
        $provList = $repo->getprovinciaListWithCimasCount($communidadId);
        return view('publicarea.listadoprovincias',compact('provList'));
    }
}
