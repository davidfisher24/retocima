<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enlace extends Model
{
    /**
     * Relationship - Each enlace belongs to a single vertiente 
     *
     * @collection cimeros
     */
    public function vertiente()
    {
        return $this->belongsTo('App\Vertiente');
    }
}
