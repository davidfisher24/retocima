<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use JWTAuth;
use JWTAuthException;
use App\Cimero;
use App\Pais;
use App\Provincia;
use App\Communidad;
use App\Logro;
use App\Cima;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Services\CimeroLogroService;
use Mail;
use App\Mail\WelcomeEmail;


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
        return response()->json([
            'cimero' => JWTAuth::toUser($request->bearerToken()),
        ],200);      
    }

    public function refresh(Request $request)
    {
        if ($refresh = JWTAuth::refresh($request->bearerToken())) return response()->json(['token'=> $refresh],200); 
        return response()->json([
            'message' => 'failed to verify',
        ],401);       
    }

    public function register(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return response()->json($validator->messages(),400);
        }
        $cimero = $this->create($request->all());
        if($cimero) {
            Mail::to($request->input('email'))->send(new WelcomeEmail([
                'name' => $cimero->nombre,
            ]));
            return response()->json([
                'cimero' => $cimero,
                'token' => JWTAuth::attempt($request->all()),
            ]);
        }
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
        return Cimero::with('provincia','pais')->find($cimero->id)->toJson();        
    }

    public function profileAction(Request $request){
        $cimero = JWTAuth::toUser($request->token);
        $cimero = Cimero::with('provincia','pais')->find($cimero->id);
        $logros = $this->cimeroLogroService->getLogros($cimero->id);
        $provinces = Provincia::withCount('activeCimas')->get();
        $communidads = Communidad::withCount('activeCimas')->get();

        return array(
            "cimero" => $cimero,
            "logros" => $logros,
            "provincias" => $provinces,
            "communidads" => $communidads
        );
    }

    public function logrosProvinciaAction(Request $request, $provincia){
        $cimero = JWTAuth::toUser($request->token);
        return $this->cimeroLogroService->getLogrosInProvince($cimero->id, $provincia);
    }

    public function updateLogroAction(Request $request)
    {   
        $cimero = JWTAuth::toUser($request->token);
        if ($request->get('action') === "add") {
            $logro = json_decode($request->get('cima'));
            $added = $this->cimeroLogroService->validateAndAddNewLogro($logro,$cimero->id);
            return Logro::with('provincia','communidad','cima')->where('cimero_id',$cimero->id)->where('cima_id',$request->get('cima'))->first()->toJson();
        } else if ($request->get('action') === "remove") {
            $logro = json_decode($request->get('logro'));
            $delete = $this->cimeroLogroService->removeExistingLogro($logro,$cimero->id);
            return Cima::with('provincia','communidad')->find($logro->cima_id)->toJson();
        } 
    }

    public function checkLogroAction(Request $request, $cimaId){
        $cimero = JWTAuth::toUser($request->token);
        $logro = Logro::where('cima_id',$cimaId)->where('cimero_id',$cimero->id)->first();
        return $logro ? $logro->toJson() : null;
    }

    public function updatePasswordAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'old' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(),400);
        }
 
        $cimero = JWTAuth::toUser($request->token);
        $user = Cimero::find($cimero->id);
        $hashedPassword = $user->password;
 
        if (Hash::check($request->old, $hashedPassword)) {
            $user->fill([
                'password' => Hash::make($request->password)
            ])->save();
 
            return response(array(
                "status" => "success",
                "message" => "Tu contrasena ha sido actualizado",
            ), 200);
        }

        return response(array(
            "status" => "failure",
            "message" => "Contrasena no correcta",
        ),400);
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
