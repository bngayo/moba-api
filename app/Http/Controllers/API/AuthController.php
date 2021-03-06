<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\API\RegisterRequest;
use App\Http\Requests\API\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (Auth::attempt(['email' => $request->email,'password' => $request->password])) {
            $user = Auth::user();
            
            $data = [
                'id' => $user->id,
                'token_type' => 'Bearer',
                'access_token' => $user->createToken('MobaApp')->plainTextToken
            ];

            return $this->sendResponse($data, 'User login successfully.');
        } else {
            return $this->sendError('Invalid credentials. Please retry', [], 401);
        }
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create(
            $request->validated()
        );

        $success['id'] = $user->id;
        $success['name'] = $user->name;
   
        return $this->sendResponse($success, 'User registered successfully.');
    }

    public function getUser(Request $request)
    {
        // $user = User::with('activeSubscription')->find($request->user('sanctum')->id);
        
        $data = new UserResource($request->user('sanctum'));

        return $this->sendResponse($data, '');
    }
}
