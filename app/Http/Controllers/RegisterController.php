<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Http\Requests\BasicInfoStoreRequest;
use Monarobase\CountryList\CountryListFacade;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\SubscriptionPlanCollection;
use App\Http\Resources\SubscriptionPlanResource;
use App\Http\Resources\SubscriptionBillingCycleCollection;
use App\Http\Resources\SubscriptionBillingCycleResource;
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionBillingCycle;

class RegisterController extends Controller
{
    public function create()
    {
        return Inertia::render('Auth/Register', [
            'countries' => CountryListFacade::getList(),
            'years' => range(date('Y'), 1900),
            'membership_plans' => new SubscriptionPlanCollection(
                SubscriptionPlan::all()
            ),
            'billing_cycles' => new SubscriptionBillingCycleCollection(
                SubscriptionBillingCycle::all()
            ),
        ]);
    }

    public function store(RegisterRequest $request)
    {
        dd($request->validated());
        $user = User::create($request->validated());
       
        return Redirect::route('subscription.payment', $user->id);
    }
}
