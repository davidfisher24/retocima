<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use JWTAuth;
use JWTAuthException;
use App\Cimero;
use App\Pais;
use App\Logro;
use App\Cima;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Services\CimeroLogroService;


class AuthController extends Controller
{

    use RegistersUsers;

    public function __construct(CimeroLogroService $cimeroLogroService)
    {
        $this->cimeroLogroService = $cimeroLogroService;
    }

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

    public function updateAccountAction(Request $request)
    {
        $cimero = JWTAuth::toUser($request->token);
        $validator = $this->updateValidator($request->all(),$cimero->id);
        if ($validator->fails()) {
            return response()->json($validator->messages(),400);
        }
        $cimero->update($request->all());
        $cimero->save();
        return Cimero::with('provincia','pais','logros','logros.provincia','logros.communidad','logros.cima')->find($cimero->id)->toJson();        
    }

    public function profileAction(Request $request){
        $cimero = JWTAuth::toUser($request->token);
        return Cimero::with('provincia','pais','logros','logros.provincia','logros.communidad','logros.cima')->find($cimero->id)->toJson();
    }

    public function logrosProvinciaAction(Request $request, $provincia){
        $cimero = JWTAuth::toUser($request->token);
        $complete = Logro::with('provincia','communidad','cima')->where('cimero_id',$cimero->id)->where('provincia_id',$request->provincia)->where('cima_estado',1)->get();
        $incomplete = Cima::with('provincia','communidad')->where('provincia_id',$request->provincia)->where('estado',1)->whereNotIn('id',$complete->pluck('cima_id'))->get();
        return json_encode(["complete" => $complete, "incomplete" => $incomplete]);
    }

    public function updateLogroAction(Request $request)
    {   
        $cimero = JWTAuth::toUser($request->token);
        if ($request->get('action') === "add") {
            $logros = array($request->get('cima'));
            $added = $this->cimeroLogroService->validateAndAddNewLogros($logros,$cimero->id);
            return Logro::with('provincia','communidad','cima')->where('cimero_id',$cimero->id)->where('cima_id',$request->get('cima'))->first()->toJson();
        } else if ($request->get('action') === "remove") {
            $logro = json_decode($request->get('logro'));
            $delete = $this->cimeroLogroService->removeExistingLogro($logro);
            return Cima::with('provincia','communidad')->find($logro->cima_id)->toJson();
        } 
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
     * Get a validator for an incoming update account request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    protected function updateValidator($data,$cimeroId)
    {
        $spain = (string) Pais::spain();
        $before = date("Y-m-d",strtotime("-13 years"));
        $after = date("Y-m-d",strtotime("-100 years"));

        return Validator::make($data, [
            'nombre' => 'required|string|max:50|min:3',
            'apellido1' => 'required|string|max:50|min:3',
            'apellido2' => 'string|max:50|nullable',
            'username' => 'required|string|max:50',
            'email' => 'required|string|email|max:255|unique:cimeros,email,'.$cimeroId,
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
