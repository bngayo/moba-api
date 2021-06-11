<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\API\RegisterRequest;
use App\Http\Requests\API\UpdateSchoolInfoRequest;

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

    public function updateBasicInfo(User $user, UpdateBasicInfoRequest $request)
    {
        $user->update(
            $request->validated()
        );

        return $this->sendResponse([], 'Basic info updated successfully.');
    }

    public function updateSchoolInfo(User $user, UpdateSchoolInfoRequest $request)
    {
        $user->update(
            $request->validated()
        );

        return $this->sendResponse([], 'School info updated successfully.');
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
