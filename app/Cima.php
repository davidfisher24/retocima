<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cima extends Model
{
    /**
     * Relationship - One cima has various vertientes
     *
     * @collection vertientes
     */
    public function vertientes()
    {
        return $this->hasMany('App\Vertiente', 'id_cima');
    }

    /**
     * Relationship - One cima has various logros by the cimeros
     *
     * @collection logros
     */
    public function logros()
    {
        return $this->hasMany('App\Logro', 'id_cima');
    }

    /**
	 * Returns all cimas ranked by number of ascesions (logros)
	 *
	 * @collection cimas ranked by ascensions
	 */
    public static function orderByAscensions()
    {
    	return Self::all()->map(function ($cima) {
		    $cima['ascensionesCount'] = $cima->logros()->count();
		    return $cima;
		})->sortByDesc('ascensionesCount');
    }
}
