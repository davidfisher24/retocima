<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

use App\Cima;
use App\Logro;

class CimaController extends Controller
{

    //$c = new App\Http\Controllers\CimaController(new App\Cima());

    protected $model;

    public function __construct(Cima $model)
    {
        $this->model = $model;
    }

    public function one($id,$appends = ['provincia','communidad','vertientes'],$appendsCount = ['logros'])
    {   
        return $this->model
            ->with($appends)
            ->withCount($appendsCount)
            ->find($id);
    }

    public function all($appends = ['provincia','communidad','vertientes'],$appendsCount = ['logros'])
    {
        return $this->model
        ->with($appends)
        ->withCount($appendsCount)
        ->get();
    }

    public function query($params,$appends = ['provincia','communidad','vertientes'],$appendsCount = ['logros'])
    {
        $query = $this->model->query();
        foreach ($params as $p) $query = $query->where($p[0], $p[1]);
        return $query->with($appends)->withCount($appendsCount)->get();
    }

    /*
     * Finds all cimas in a province
     */
    public function oneAction($id)
    {
    	return Cima::with('provincia','communidad','vertientes','vertientes.enlaces')->withCount('logros')->find($id)->toJSON();
    }

    /*
     * Finds all cimas in a province
     */
    public function allAction()
    {
    	return Cima::with('provincia','communidad','vertientes','vertientes.enlaces')->withCount('logros')->get()->toJSON();
    }

    /*
     * Finds all cimas in a province
     */
    public function allInProviceAction($provinciaId)
    {
    	return Cima::where('provincia_id',$provinciaId)->with('vertientes','vertientes.enlaces')->withCount('logros')->get()->toJSON();
    }

    /*
     * All Cimas ranked by logros
     */
     // select cimas.*, count(logros.cima_id) as logros_count from cimas left join logros on cimas.id = logros.cima_id group by cimas.id;

    public function rankAction()
    {
    	$cimas = DB::table('cimas')
	    	->select(DB::raw(
	    		'cimas.*, 
	    		count(logros.cima_id) as logros_count,
	    		provincias.nombre as provinciaName'
	    	))
	    	->leftJoin('logros', 'cimas.id', '=', 'logros.cima_id')
	    	->leftJoin('provincias', 'cimas.provincia_id', '=', 'provincias.id')
	        ->groupBy('cimas.id')
	        ->orderBy('logros_count','desc')
	        ->get();
    	return $cimas;
    }

    /*
     * All pata negra cimas
     */

    public function pataNegraAction()
    {
        return Cima::with('provincia','communidad','vertientes')->withCount('logros')->where('pata_negra',1)->get()->toJSON();
    }

    /*
     * Returns a view for cima details
     */

    public function showCimaPageAction($cimaId)
    {
        $userLogro = Logro::where('cimero_id',Auth::id())->where('cima_id',$cimaId)->first();
        $cima = Cima::with('provincia','communidad','vertientes')->withCount('logros')->find($cimaId);
        return view('publicarea.detallescima',compact('cima','userLogro'));
    }

    

}
