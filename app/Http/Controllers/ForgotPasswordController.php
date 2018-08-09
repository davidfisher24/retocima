<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
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


class ForgotPasswordController extends Controller
{

    use SendsPasswordResetEmails;

    public function __construct() {}


    public function forgotPasswordAction(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(),400);
        }

        $cimero = Cimero::where('email', $request->input('email'))->first();
        if (!$cimero) return response()->json([
                'message' => 'No hay usuario con este correo electronico',
        ],400);

        $token = $this->broker()->createToken($cimero);
        return response()->json([
            'token' => $token,
        ],200);
    }


}
