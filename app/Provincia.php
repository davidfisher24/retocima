<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    /**
     * Relationship - Each provincia has many Cimas
     *
     * @collection cimas
     */
    public function cimas()
    {
        return $this->hasMany('App\Cima');
    }

    /**
     * Relationship - Each provincia has many logros
     *
     * @collection logros
     */
    public function logros()
    {
        return $this->hasMany('App\Logro');
    }

    /**
     * Relationship - Each province has one communidad
     *
     * @object communidad
     */
    public function communidad()
    {
        return $this->hasOne('App\Communidad','id','communidad_id');
    }

    /**
     * Relationship - Each province has one iberia
     *
     * @object iberia
     */
    public function iberia()
    {
        return $this->hasOne('App\Iberia','id','iberia_id');
    }
}
