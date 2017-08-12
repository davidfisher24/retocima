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
        return $this->belongsTo('App\Cimero','id_cimero','id');
    }

    /**
     * Relationship - Each logro belongs to a single cima
     *
     * @collection cimeros
     */
    public function cima()
    {
        return $this->belongsTo('App\Cima','id_cima','id');
    }
}
