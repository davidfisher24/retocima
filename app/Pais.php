<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $table = 'paises';

    /**
     * Relationship - Each pais belongs to many cimeros
     *
     * @collection cimeros
     */
    public function cimeros()
    {
        return $this->belongsTo('App\Cimero','id','pais');
    }

    /** 
     * Returns the id of Spain
     *
     * @return integer $spainId
     */

    public static function spain()
    {
        return Self::where('nombre','Espana')->first()->id;
    }

    /** 
     * Returns countries in alphabetical order with Spain first
     *
     * @return integer $spainId
     */

    public static function spainFirstList()
    {
        $list = Self::all()->except(Self::spain())->sortBy('nombre');
        return $list->prepend(Self::find(Self::spain()));
    }
}
