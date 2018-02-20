<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Services\CimeroLogroService;
use App\Services\MapService;

use App\Cimero;
use App\Cima;
use App\Provincia;
use App\Pais;
use App\Logro;

class CimeroCuentaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param service $cimeroLogroService
     *
     * @return cimero controller
     */

    public function __construct(CimeroLogroService $cimeroLogroService, MapService $mapService)
    {
        $this->middleware('auth');
        $this->cimeroLogroService = $cimeroLogroService;
        $this->mapService = $mapService;
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
    	
    	$cimero = Cimero::with('provincia','pais')->find(Auth::id());
        $provincias = Provincia::orderBy('nombre','asc')->get();
        $paises = Pais::spainFirstList();
    	
        return view('userarea.cimeroCuenta', compact('cimero','provincias','paises'));
    }

    /**
     * Process edit account form including vallidation.
     *
     * @param request
     * @return {object} cimero
     */

    public function editarCuenta(Request $request)
    {
        $cimero = Auth::user();
        $errors = $this->validator($request->all(),$cimero);
        if (count($errors) > 0) return json_encode(array("errors" => $errors));
        $cimero = Auth::user();
        $cimero->update($request->all());
        $cimero->save();
        $cimero = Cimero::with('provincia','pais')->find(Auth::id());
        return $cimero;
        
    }


    /**
     * Show the cimero statistics page
     *
     * @return Blade View
     */

    public function cimeroStatistics()
    {

        $cimas = $this->cimeroLogroService->getCimeroWithDetailedLogros(Auth::id());
        $map = $this->mapService->makeBasicCimasMap($cimas);
        return view('userarea.cimeroStatistics');
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

    /**
     * Show the anadir cima page
     *
     * @param request
     * @return Update or remove object
     */

    public function updateLogro(Request $request)
    {   
        if ($request->get('action') === "add") {
            $logros = array($request->get('cima'));
            $added = $this->cimeroLogroService->validateAndAddNewLogros($logros,Auth::id());
            return Logro::where('cimero_id',Auth::id())->where('cima_id',$request->get('cima'))->first();
        } else if ($request->get('action') === "remove") {
            $delete = $this->cimeroLogroService->removeExistingLogro(json_decode($request->get('logro')));
            return $delete;
        } 
    }



    /**
     * Get a validator for an incoming update account request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    protected function validator($data,$cimero)
    {
        $spain = (string) Pais::spain();
        $before = date("Y-m-d",strtotime("-13 years"));
        $after = date("Y-m-d",strtotime("-100 years"));

        $validator = Validator::make($data, [
            'nombre' => 'required|string|max:50|min:3',
            'apellido1' => 'required|string|max:50|min:3',
            'apellido2' => 'string|max:50|nullable',
            'username' => 'required|string|max:50',
            'email' => 'required|string|email|max:255|unique:cimeros,email,'.$cimero->id,
            'provincia' => 'required_if:pais,'.$spain,
            'pais' => 'required',
            'fechanacimiento' => 'required|date|date_format:Y-m-d|before:'.$before.'|after:'.$after,
        ]);

        return $validator->errors();
    }

    

}
