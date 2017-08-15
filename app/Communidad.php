<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Communidad extends Model
{
    /**
     * Relationship - Each communidad belongs to a many cimas
     *
     * @collection cimas
     */
    public function cimas()
    {
        return $this->belongsTo('App\Cima');
    }

    /**
     * Relationship - Each communidad belongs to a many logros
     *
     * @collection logros
     */
    public function logros()
    {
        return $this->belongsTo('App\Logro');
    }

    /**
     * Relationship - Each communidad belongs to a many provincias
     *
     * @collection provincias
     */
    public function provincias()
    {
        return $this->belongsTo('App\Provincia');
    }


}
