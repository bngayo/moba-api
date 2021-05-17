<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Http\Requests\BasicInfoStoreRequest;
use Monarobase\CountryList\CountryListFacade;
use Illuminate\Support\Facades\Redirect;

class RegisterController extends Controller
{
    public function create()
    {
        return Inertia::render('Auth/Register', [
            'countries' => CountryListFacade::getList()
        ]);
    }

    public function store(BasicInfoStoreRequest $request)
    {
        $user = User::create($request->validated());
       
        return Redirect::route('register')->with('success', 'User created.');
    }
}
