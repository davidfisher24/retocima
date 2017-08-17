<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Services\CimeroLogroService;
use App\Cimero;
use App\Cima;

class CimeroController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
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
    	
        return view('userarea.cimeroCuenta', compact('cimero'));
    }

    /**
     * Show the cimero logros page.
     *
     * @return Blade View
     */

    public function cimeroLogros()
    {
    	$service = new CimeroLogroService();
    	$logros = $service->getCimeroWithDetailedLogros(Auth::id());
    	
    	return view('userarea.cimeroLogros', compact('logros'));
    }

    /**
     * Show the anadir cima page
     *
     * @return Blade View
     */

    public function anadirLogros()
    {
        //$service = new CimeroLogroService();
        //$logros = $service->getCimeroWithDetailedLogros(Auth::id());
        $cimas = Cima::all();
        return view('userarea.anadirLogros', compact('cimas'));
    }
}
