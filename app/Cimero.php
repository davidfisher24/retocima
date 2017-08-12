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
        'name', 'email', 'password',
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
        return $this->hasMany('App\Logro', 'id_cimero');
    }


	 /**
	 * Returns all cimeros ranked by numero of logros
	 *
	 * @collection cimeros ranked by logros
	 */
    public static function rank()
    {
    	return Self::all()->map(function ($cimero) {
		    $cimero['logrosCount'] = $cimero->logros()->count();
		    return $cimero;
		})->sortByDesc('logrosCount');
    }
}
