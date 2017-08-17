<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\CimasListService;

class CimasController extends Controller
{
    /**
     * Show the list of cimas.
     *
     * @return Blade View
     */

    public function listCimas()
    {
    	
    	$service = new CimasListService();
    	$cimaList = $service->getCommunidadsWithNumberOfCimas();
        return view('publicarea.listado',compact('cimaList'));
    }
}
