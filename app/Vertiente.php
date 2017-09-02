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
        return $this->belongsTo('App\Cima');
    }

    /**
     * Relationship - Vertiente has various enlaces logros
     *
     * @collection enlaces
     */
    public function enlaces()
    {
        return $this->hasMany('App\Enlace');
    }
}
