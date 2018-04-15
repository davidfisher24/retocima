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
     * Relationship - Each provincia has many Cimas which are active (cimas estado = 1)
     *
     * @collection cimas
     */
    public function activeCimas()
    {
        return $this->hasMany('App\Cima')->where('estado',1);
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
    
    /**
     * Relationship - Each provincia belongs to many cimeros
     *
     * @collection cimeros
     */
    public function cimeros()
    {
        return $this->belongsTo('App\Cimero','id','provincia');
    }
}
