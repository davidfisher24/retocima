<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    /**
     * Relationship - Each provincia belongs to a many cimas
     *
     * @collection cimas
     */
    public function cimas()
    {
        return $this->belongsTo('App\Cima');
    }

    /**
     * Relationship - Each provincia belongs to a many logros
     *
     * @collection logros
     */
    public function logros()
    {
        return $this->belongsTo('App\Logro');
    }

    /**
     * Relationship - Each province has one communidad
     *
     * @object communidad
     */
    public function communidad()
    {
        return $this->hasOne('App\Communidad');
    }

    /**
     * Relationship - Each province has one iberia
     *
     * @object iberia
     */
    public function iberia()
    {
        return $this->hasOne('App\Iberia');
    }
}
