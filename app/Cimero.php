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
        'nombre', 'apellido1', 'apellido2', 'fechanacimiento', 'direccion', 'poblacion', 'provincia', 'codigopostal', 'email',
        'web', 'puertofavorito', 'puertomasduro', 'puertomasfacil', 'bicicleta', 'desarrollo', 'grupo', 'frase', 'username', 'password',
        'nickmiarroba', 'fechaalta'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
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
     * Relationship - User has various logros
     *
     * @collection logros
     */
    public function logros()
    {
        // Filtering without the special ones
        return $this->hasMany('App\Logro')->where('cima_estado','!=', 4);
    }


}


