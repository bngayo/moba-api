<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function create()
    {
        return Inertia::render('Auth/Register');
    }

    public function store(UserStoreRequest $request)
    {
        Auth::user()->account->users()->create(
            $request->validated()
        );

        return Redirect::route('users')->with('success', 'User created.');
    }
}
