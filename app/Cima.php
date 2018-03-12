<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\TextSearch;

class Cima extends Model
{

    use TextSearch;

    protected $searchable = [
        'nombre'
    ];

    /**
     * scope - return only active
     *
     * @return query
    */

    public function scopeActive($query)
    {
        return $query->where('estado', 1);
    }

    /**
     * scope - return active and eliminated
     *
     * @return query
    */

    public function scopeActiveAndEliminated($query)
    {
        return $query->whereIn('estado', [1,3]);
    }

    /**
     * scope - return active and substituted
     *
     * @return query
    */

    public function scopeActiveAndSubstituted($query)
    {
        return $query->whereIn('estado', [1,2]);
    }

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
     * Relationship - One cima has various logros 
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
        return $this->hasOne('App\Provincia','id','provincia_id');
    }

    /**
     * Relationship - One cima has one communidad
     *
     * @object provincia
     */
    public function communidad()
    {
        return $this->hasOne('App\Communidad','id','communidad_id');
    }

     /**
     * Relationship - One cima has one iberia
     *
     * @object provincia
     */
    public function iberia()
    {
        return $this->hasOne('App\Iberia','id','iberia_id');
    }


}
