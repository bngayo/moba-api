<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Http\Resources\UserResource;

class PaymentsController extends Controller
{
    public function create(User $user)
    {
        return Inertia::render('Auth/Payment', [
            'user' => new UserResource($user->load('activeSubscription'))
        ]);
    }
}
