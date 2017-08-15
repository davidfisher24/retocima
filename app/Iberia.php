<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Iberia extends Model
{
    /**
     * Relationship - Each iberia belongs to a many cimas
     *
     * @collection cimas
     */
    public function cimas()
    {
        return $this->belongsTo('App\Cima');
    }

    /**
     * Relationship - Each iberia belongs to a many logros
     *
     * @collection logros
     */
    public function logros()
    {
        return $this->belongsTo('App\Logro');
    }

    /**
     * Relationship - Each iberia belongs to a many provincias
     *
     * @collection provincias
     */
    public function provincias()
    {
        return $this->belongsTo('App\Provincia');
    }

}
