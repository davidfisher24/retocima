<?php

namespace App;
use DateTime;
use App\Pais;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Cimero extends Authenticatable
{
    use Notifiable;

    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            self::emptyProvinceIfNotSpain($model);
        });

        self::updating(function($model){
            self::emptyProvinceIfNotSpain($model);
        });
    }

    public function __construct(array $attributes = array()) {
        parent::__construct($attributes);
    }

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

    protected $appends = ["fullname"];

    /**
     * Mutator - Ensures correct date time format
     *
     * @return datetime fechanacimiento
     */
    public function getFechanacimientoAttribute($value){
        $date = DateTime::createFromFormat('d/m/Y', $value);
        if ($date !== FALSE) return date_format($date, 'Y-m-d');
        return $value;
    }

    public function getFullnameAttribute () {
        return $this->nombre . " " . $this->apellido1 . " " . $this->apellido2;
    }

    /**
     * Mutator -Ensures empty province if country is not Spain
     *
     * @param model
     */
    protected static function emptyProvinceIfNotSpain($model){
        if ($model->pais !== Pais::spain()) $model->provincia = null;
    }

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

    public function calculateLogros()
    {
        $count = 0;
        $logros = $this->logros()->with('cima')->get();

        foreach($logros as $logro) {
            if ($logro->cima->estado === 1) $count++;

            if ($logro->cima->estado === 2) {
                $completedPrevious = false;
                for($i = 0; $i < count($logros); $i++) {
                    if($logros[$i]->cima_id == $logro->cima->substituted) {
                        $completedPrevious = true;
                        break;
                    }
                }
                if(!$completedPrevious) $count++;
            }

        }
        $this->logro_count = $count;
        $this->save();
        return;
    }


}


