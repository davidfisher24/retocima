<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    /**
     * Relationship - Each provincia has many Cimas
     *
     * @collection cimas
     */
    public function cimas()
    {
        return $this->hasMany('App\Cima');
    }

    /**
     * Relationship - Each provincia has many Cimas
     *
     * @collection cimas
     */
    public function totalCimasInProvince()
    {
    	// DO I need this or is it better in the database?
        return $this->cimas->filter(function($value,$key){
        	return $value->estado === 1;
        })->count();
    }

    /**
     * Relationship - Each provincia has many logros
     *
     * @collection logros
     */
    public function logros()
    {
        return $this->hasMany('App\Logro');
    }

    /**
     * Relationship - Each province has one communidad
     *
     * @object communidad
     */
    public function communidad()
    {
        return $this->hasOne('App\Communidad','id','communidad_id');
    }

    /**
     * Relationship - Each province has one iberia
     *
     * @object iberia
     */
    public function iberia()
    {
        return $this->hasOne('App\Iberia','id','iberia_id');
    }

    // FUNCTIONS TO MOVE TO SERVICE LAYER
    public static function orderByAscensions()
    {
        return Self::all()->map(function ($province) {
            $province['ascensionesCount'] = $province->logros()->count();
            return $province;
        })->sortByDesc('ascensionesCount')->pluck('ascensionesCount','nombre');
    }

    
}
