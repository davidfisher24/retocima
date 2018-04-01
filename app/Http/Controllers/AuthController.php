<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use JWTAuth;
use JWTAuthException;
use App\Cimero;
use App\Pais;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;


class AuthController extends Controller
{

    use RegistersUsers;

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $token = null;
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'message' => 'invalid_email_or_password',
                ],400);
            }
        } catch (JWTAuthException $e) {
            return response()->json([
                'message' => 'failed_to_create_token',
            ],400);
        }
        return response()->json([
            'cimero' => JWTAuth::toUser($token),
            'token' => $token,
        ],200);
    }

    public function verify(Request $request)
    {
        $cimero = JWTAuth::toUser($request->token);     
        if (!$cimero) return response()->json([
            'message' => 'failed to verify',
        ],400);       
        return response()->json([
            'cimero' => $cimero,
            'token' => $request->token,
        ]);
    }

    public function register(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return response()->json($validator->messages(),400);
        }
        $cimero = $this->create($request->all());
        if($cimero) return response()->json([
            'cimero' => $cimero,
            'token' => JWTAuth::attempt($request->all()),
        ]);
    }

    public function profileAction(Request $request){
        $cimero = JWTAuth::toUser($request->token);
        return Cimero::with('provincia','pais','logros','logros.provincia','logros.communidad','logros.cima')->find($cimero->id)->toJson();
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
            'apellido2' => 'string|max:50|nullable',
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
    

}
