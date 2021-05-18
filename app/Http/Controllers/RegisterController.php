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
            'countries' => CountryListFacade::getList(),
            'years' => range(date('Y'), 1900)
        ]);
    }

    public function store(RegisterStoreRequest $request)
    {
        $user = User::create($request->validated());
       
        return Redirect::route('register.details', $user->id);
    }
}
