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
     * Relationship - User has various logros
     *
     * @collection logros
     */
    public function logros()
    {
        // Filtering without the special ones
        return $this->hasMany('App\Logro')->where('cima_estado','!=', 4);
    }

    // FUNCTIONS TO MOVE TO SERVICE LAYER

	 /**
	 * Returns all cimeros ranked by numero of logros
	 *
	 * @collection cimeros ranked by logros
	 */
    public static function rank()
    {
    	return Self::all()->map(function ($cimero) {
		    $cimero['logrosCount'] = $cimero->logros()->count();
            $cimero['fullname'] = $cimero->nombre . " ". $cimero->apellido1 . " " . $cimero->apellido2;
		    return $cimero;
		})->sortByDesc('logrosCount')->pluck('logrosCount','fullname');
    }

}


