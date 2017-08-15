<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Iberia extends Model
{
    /**
     * Relationship - Each iberia has many cimas
     *
     * @collection cimas
     */
    public function cimas()
    {
        return $this->hasMany('App\Cima');
    }

    /**
     * Relationship - Each iberia has many logros
     *
     * @collection logros
     */
    public function logros()
    {
        return $this->hasMany('App\Logro');
    }

    /**
     * Relationship - Each iberia has many provincias
     *
     * @collection provincias
     */
    public function provincias()
    {
        return $this->hasMany('App\Provincia');
    }

}

