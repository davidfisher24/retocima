<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $table = 'paises';

    /**
     * Relationship - Each pais belongs to many cimeros
     *
     * @collection cimeros
     */
    public function cimeros()
    {
        return $this->belongsTo('App\Cimero','id','pais');
    }
}
