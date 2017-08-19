<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Services\CimeroLogroService;

use App\Cimero;
use App\Cima;

class CimeroCuentaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param service $cimeroLogroService
     *
     * @return cimero controller
     */

    public function __construct(CimeroLogroService $cimeroLogroService)
    {
        $this->middleware('auth');
        $this->cimeroLogroService = $cimeroLogroService;
    }

    /**
     * Show the application dashboard.
     *
     * @return Blade View
     */

    public function dashboard()
    {
    	
    	$cimero = Cimero::find(Auth::id());
    	
        return view('userarea.dashboard', compact('cimero'));
    }

    /**
     * Show the cimro cuenta.
     *
     * @return Blade View
     */

    public function cimeroCuenta()
    {
    	
    	$cimero = Cimero::find(Auth::id());
        $cimero->fullAddress = $cimero->getFullAddress();
        $cimero->fullName = $cimero->getFullName();
    	
        return view('userarea.cimeroCuenta', compact('cimero'));
    }

    /**
     * Show the cimero logros page.
     *
     * @return Blade View
     */

    public function cimeroLogros()
    {
    	$logros = $this->cimeroLogroService->getCimeroWithDetailedLogros(Auth::id());
    	
    	return view('userarea.cimeroLogros', compact('logros'));
    }

    /**
     * Show the anadir cima page
     *
     * @return Blade View
     */

    public function anadirLogros()
    {
        $userLogros = $this->cimeroLogroService->getCimeroLogrosCimaIds(Auth::id());
        $cimas = Cima::all();
        return view('userarea.anadirLogros', compact('cimas'), compact('userLogros'));
    }
}
