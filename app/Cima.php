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
        return $this->hasMany('App\Vertiente');
    }

    /**
     * Relationship - One cima has various logros by the cimeros
     *
     * @collection logros
     */
    public function logros()
    {
        return $this->hasMany('App\Logro');
    }

    /**
     * Relationship - One cima has one provincia
     *
     * @object provincia
     */
    public function provincia()
    {
        return $this->hasOne('App\Provincia');
    }

    /**
     * Relationship - One cima has one communidad
     *
     * @object provincia
     */
    public function communidad()
    {
        return $this->hasOne('App\Communidad');
    }

     /**
     * Relationship - One cima has one iberia
     *
     * @object provincia
     */
    public function iberia()
    {
        return $this->hasOne('App\Iberia');
    }



    /**
	 * Returns all cimas ranked by number of ascesions (logros)
	 *
	 * @collection cimas ranked by ascensions
	 */
    /*public static function orderByAscensions()
    {
    	return Self::all()->map(function ($cima) {
		    $cima['ascensionesCount'] = $cima->logros()->count();
		    return $cima;
		})->sortByDesc('ascensionesCount');
    }*/
}
