<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Communidad extends Model
{
    /**
     * Relationship - Each communidad has many cimas
     *
     * @collection cimas
     */
    public function cimas()
    {
        return $this->hasMany('App\Cima');
    }

    /**
     * Relationship - Each communidad has many Cimas which are active (cimas estado = 1)
     *
     * @collection cimas
     */
    public function activeCimas()
    {
        return $this->hasMany('App\Cima')->where('estado',1);
    }

    /**
     * Relationship - Each communidad has many logros
     *
     * @collection logros
     */
    public function logros()
    {
        return $this->hasMany('App\Logro');
    }

    /**
     * Relationship - Each communidad has many provincias
     *
     * @collection provincias
     */
    public function provincias()
    {
        return $this->hasMany('App\Provincia');
    }


}
