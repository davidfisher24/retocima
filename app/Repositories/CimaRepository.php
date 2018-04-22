<?php

namespace App\Repositories;

use DB;

use App\Cima;

class CimaRepository 
{
	protected $model;

	/**
    * Set class to injected model
    * 
    * @param Model $logro
    * @return void
    */

	public function __construct(Cima $model) {
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

}
