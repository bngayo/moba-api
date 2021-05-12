<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function store(RegisterRequest $request)
    {
        $user = User::create(
            $request->validated()
        );

        $data = [
            'id' => $user->id,
            'access_token' => $user->createToken('MobaApp')->plainTextToken
        ];
   
        return $this->sendResponse($data, 'User registered successfully.');
    }

    public function uploadPhoto(RegisterRequest $request)
    {
        $user = User::create(
            $request->validated()
        );

        $success['id'] = $user->id;
        $success['name'] = $user->name;
   
        return $this->sendResponse($success, 'User registered successfully.');
    }

    public function update(RegisterRequest $request)
    {
        $user = User::create(
            $request->validated()
        );

        $success['id'] = $user->id;
        $success['name'] = $user->name;
   
        return $this->sendResponse($success, 'User registered successfully.');
    }
}
