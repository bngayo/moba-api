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
        return Inertia::render('Auth/RegisterBasicInfo', [
            'countries' => CountryListFacade::getList()
        ]);
    }

    public function store(BasicInfoStoreRequest $request)
    {
        $user = User::create($request->validated());
       
        return Redirect::route('register.details', $user->id);
    }

    public function showDetailsForm()
    {
        return Inertia::render('Auth/RegisterSchoolDetails', [
            'years' => range(date('Y'), 1900)
        ]);
    }
}
