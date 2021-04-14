<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\API\RegisterRequest;
use App\Http\Requests\API\LoginRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (Auth::attempt(['email' => $request->email,'password' => $request->password])) {
            $user = Auth::user();
            
            $success['token'] =  $user->createToken('MobaApp')->plainTextToken;
            $success['name'] =  $user->name;

            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Invalid credentials. Please retry', []);
        }
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create($request->except('confirm_password'));

        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;
   
        return $this->sendResponse($success, 'User registered successfully.');
    }
}
