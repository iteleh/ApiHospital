<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Validator;
use Mail;
use App\Mail\WelcomeEmail;

class RegisterController extends BaseController
{
    /**
    * Register api
    *
    * @return \Illuminate\Http\Response
    */
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phonenumber' => 'required',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|confirmed',
        ]);

       $validatedData['referal_code'] = $request->referal_code;
       $validatedData['name'] = $request->first_name . ' ' .$request->last_name;
       $validatedData['password'] = bcrypt($request->password);

       $user = User::create($validatedData);

       Mail::to($user->email)->send(new WelcomeEmail($user));

       return response()->json(['message'=>'User has been registered'], 200);
    
    }

    /**
    * Login api
    *
    * @return \Illuminate\Http\Response
    */
    public function login(Request $request)
    {
        
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['message' => 'Invalid Credentials']);
        }
        
        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['user' => auth()->user(), 'access_token' => $accessToken, 'message' => 'Login successfully'], 200);        
        
    }
}
