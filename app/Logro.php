<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logro extends Model
{
    /**
     * Relationship - Each logro belongs to a single cimero
     *
     * @collection cimeros
     */
    public function cimero()
    {
        return $this->belongsTo('App\Cimero');
    }

    /**
     * Relationship - Each logro belongs to a single cima
     *
     * @collection cimeros
     */
    public function cima()
    {
        return $this->belongsTo('App\Cima');
    }

    /**
     * Relationship - One logro has one provincia
     *
     * @object provincia
     */
    public function provincia()
    {
        return $this->hasOne('App\Provincia');
    }

    /**
     * Relationship - One logro has one communidad
     *
     * @object provincia
     */
    public function communidad()
    {
        return $this->hasOne('App\Communidad');
    }

     /**
     * Relationship - One logro has one iberia
     *
     * @object provincia
     */
    public function iberia()
    {
        return $this->hasOne('App\Iberia');
    }
}
