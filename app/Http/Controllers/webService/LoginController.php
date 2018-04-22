<?php

namespace App\Http\Controllers\webService;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;

class LoginController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['login']]);
    }

    //login user with check cellphone and password
    public function login(Request $request)
    {
        $validation=Validator::make($request->all(),
            [
                'cellphone' => 'required',
                'password' => 'required',
            ]);
        $errors = $validation->errors();
        if(!$errors->isEmpty())
        {return response()->json($errors);}
        $credentials = $request->only('cellphone', 'password');
        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return response()->json(['token' => $token], 200);

    }
}
