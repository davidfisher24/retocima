<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Cimero;
use App\Services\EmailService;

class ResetPasswordController extends Controller
{

    use ResetsPasswords;

    public function __construct(EmailService $emailService) {
        $this->emailService = $emailService;
    }


    public function resetPasswordAction(Request $request)
    {
        $this->validate($request, $this->rules(), $this->validationErrorMessages());

        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );
        if ($response == 'passwords.reset') {
            return response()->json([
                'message' => trans('passwords.reset'),
            ],200);
        } else {
            $this->emailService->resetPasswordSuccessEmail($request->input('email'));
            return response()->json([
                'message' => trans($response),
            ],400);
        }
    }

}
