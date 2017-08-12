<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vertiente extends Model
{
    /**
     * Relationship - Each vertiente belongs to one cima
     *
     * @collection vertientes
     */
    public function cima()
    {
        return $this->belongsTo('App\Cima','id_cima','id');
    }
}
