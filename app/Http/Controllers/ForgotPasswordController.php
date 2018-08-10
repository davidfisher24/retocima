<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Cimero;
use Mail;
use App\Mail\PasswordResetEmail;


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
        $link = $_ENV['WEBAPP_URL'] . 'reset-password/' . $token;
        Mail::to($cimero->email)->send(new PasswordResetEmail([
            'link' => $link,
            'name' => $cimero->nombre,
        ]));

        return response()->json([],200);
    }

}
