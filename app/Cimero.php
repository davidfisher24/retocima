<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Cimero extends Authenticatable
{
    use Notifiable;

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'apellido1', 'apellido2', 'fechanacimiento', 'direccion', 'poblacion', 'provincia', 'pais', 'codigopostal', 'email',
        'web', 'puertofavorito', 'puertomasduro', 'puertomasfacil', 'bicicleta', 'desarrollo', 'grupo', 'frase', 'username', 'password',
        'nickmiarroba', 'fechaalta', 'direccion', 'poblacion', 'codigopostal',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'web', 'puertofavorito', 'puertomasduro', 'puertomasfacil', 'bicicleta', 'desarrollo',
        'grupo', 'frase', 'nickmiarroba', 'fechalta', 'direccion', 'poblacion', 'codigopostal', 'fechaalta'
    ];


    /**
     * Returns full name of the model
     *
     * @return string FullName
     */
    public function getFullName()
    {
        return $this->nombre . " " . $this->apellido1 . " " . $this->apellido2;
    }

    /**
     * Returns full addreess of the model
     *
     * @return string FullAddress
     */
    public function getFullAddress()
    {
        $fullAddress = $this->direccion . ", " . $this->poblacion . ", " . $this->codigopostal . ", " . $this->provincia;  
        return str_replace(", ,",",",$fullAddress);
    }
  

    /**
     * Relationship - User has various logros
     *
     * @collection logros
     */
    public function logros()
    {
        // Filtering without the special ones
        return $this->hasMany('App\Logro')->where('cima_estado','!=', 4);
    }

    /**
     * Relationship - User has one province
     *
     * @model provincia
     */
    public function provincia()
    {
        return $this->hasOne('App\Provincia','id','provincia');
    }

    /**
     * Relationship - User has one pais
     *
     * @model provincia
     */
    public function pais()
    {
        return $this->hasOne('App\Pais','id','pais');
    }

    /**
     * Returns the text of the cimeros province, or "Extranjero if non is found"
     *
     * @return {string} 
     */

    public function getProvincia()
    {
        $provincia = $this->provincia()->first();
        if (!$provincia) return "Extranjero";
        return $provincia["nombre"];
    }

    /**
     * Returns the text of the cimeros country
     *
     * @return {string} 
     */

    public function getPais()
    {
        $pais = $this->pais()->first();
        if (!$pais) return "";
        return $pais["nombre"];
    }


}


