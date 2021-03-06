<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logro extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cimero_id', 'cima_id', 'cima_codigo', 'cima_estado', 'provincia_id', 'communidad_id', 'iberia_id'
    ];


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
        return $this->hasOne('App\Provincia','id','provincia_id');
    }

    /**
     * Relationship - One logro has one communidad
     *
     * @object provincia
     */
    public function communidad()
    {
        return $this->hasOne('App\Communidad','id','communidad_id');
    }

     /**
     * Relationship - One logro has one iberia
     *
     * @object provincia
     */
    public function iberia()
    {
        return $this->hasOne('App\Iberia','id','iberia_id');
    }
}
