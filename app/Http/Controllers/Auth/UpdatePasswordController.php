<?php

namespace App\Http\Controllers\Auth;

use App\Cimero;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
 
class UpdatePasswordController extends Controller
{
    /*
     * Ensure the user is signed in to access this page
     */
    public function __construct() {
 
        $this->middleware('auth');
 
    }
 
    /**
     * Update the password for the user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'old' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);
        if ($validator->fails()) {
          return response(array(
                "status" => "failure",
                'errors'=>$validator->errors()
            ), 400);
        }
 
        $user = Cimero::find(Auth::id());
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
            "message" => "Tu contrasena no ha sido actualizado",
        ),400);
    }
}