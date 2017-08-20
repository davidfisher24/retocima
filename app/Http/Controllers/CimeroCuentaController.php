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
     * Show the cimero logros page with new logros after a redirect.
     *
     * @param array $new (new cimas added)
     * @return Blade View
     */

    public function cimeroLogrosWithNewLogros($new)
    {
        $newCimas = json_decode($new);
        $logros = $this->cimeroLogroService->getCimeroWithDetailedLogros(Auth::id())->filter(function ($item, $key) use($newCimas) {
            return !in_array($item->id,$newCimas);
        });

        $addedCimas = Cima::with('communidad','provincia')->whereIn('id',$newCimas)->get();

        return view('userarea.cimeroLogros', compact('logros'),compact('addedCimas'));
    }

    /**
     * Show the anadir cima page
     *
     * @return Blade View
     */

    public function anadirLogros()
    {
        return view('userarea.anadirLogros');
    }

    /**
     * Submit new logros from a form request
     *
     * @param request ($logros as an array of ids)
     * @return Blade View
     */

    public function submitNewLogros(Request $request)
    {   
        $addedLogros = $this->cimeroLogroService->validateAndAddNewLogros($request->logros,Auth::id());
        return array('redirect' => 'cimerologrosnew', 'new' => json_encode($addedLogros));
    }

    

}
