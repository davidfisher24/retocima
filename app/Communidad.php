<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Communidad extends Model
{
    /**
     * Relationship - Each communidad has many cimas
     *
     * @collection cimas
     */
    public function cimas()
    {
        return $this->hasMany('App\Cima');
    }

    /**
     * Relationship - Each communidad has many logros
     *
     * @collection logros
     */
    public function logros()
    {
        return $this->hasMany('App\Logro');
    }

    /**
     * Relationship - Each communidad has many provincias
     *
     * @collection provincias
     */
    public function provincias()
    {
        return $this->hasMany('App\Provincia');
    }

    // FUNCTIONS TO MOVE TO SERVICE LAYER
    public static function orderByAscensions()
    {
        return Self::all()->map(function ($communidad) {
            $communidad['ascensionesCount'] = $communidad->logros()->count();
            return $communidad;
        })->sortByDesc('ascensionesCount')->pluck('ascensionesCount','nombre');
    }


}
