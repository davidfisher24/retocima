<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Cimero;
use App\Services\EmailService;


class ForgotPasswordController extends Controller
{

    use SendsPasswordResetEmails;

    public function __construct(EmailService $emailService) {
        $this->emailService = $emailService;
    }


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
        $link = $request->root() . '/reset-password/' . $token;
        $this->emailService->resetPasswordRequestEmail($cimero->email,$link);

        return response()->json([
            //'token' => $token,
        ],200);
    }

}
