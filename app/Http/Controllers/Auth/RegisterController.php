<?php

namespace App\Http\Controllers\Auth;

use App\Cimero;
use App\Provincia;
use App\Pais;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $spain = (string) Pais::spain();
        $before = date("Y-m-d",strtotime("-13 years"));
        $after = date("Y-m-d",strtotime("-100 years"));

        return Validator::make($data, [
            'nombre' => 'required|string|max:50|min:3',
            'apellido1' => 'required|string|max:50|min:3',
            'apellido2' => 'string|max:50',
            'username' => 'required|string|max:50',
            'email' => 'required|string|email|max:255|unique:cimeros',
            'password' => 'required|string|min:6|confirmed',
            'provincia' => 'required_if:pais,'.$spain,
            'pais' => 'required',
            'fechanacimiento' => 'required|date|date_format:Y-m-d|before:'.$before.'|after:'.$after,
        ]);
    }

    /**
     * Create a new cimero instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Cimero
     */

    protected function create(array $data)
    {
        return Cimero::create([
            'nombre' => $data['nombre'],
            'apellido1' => $data['apellido1'],
            'apellido2' => $data['apellido2'],
            'username' => $data['username'],
            'email' => $data['email'],
            'provincia' => (array_key_exists('provincia',$data)) ? $data['provincia'] : null,
            'pais' => $data['pais'],
            'password' => bcrypt($data['password']),
            'fechanacimiento' => $data['fechanacimiento'],
        ]);
    }

     /**
     * Show the registration form
     *
     * @return Blade view
     */

    public function showRegistrationForm()
    {
        $provincias = Provincia::all()->sortBy('nombre');
        $paises = Pais::spainFirstList();
        $spain = Pais::spain();
        return view('auth.register', compact('provincias','paises','spain'));
    }

}
