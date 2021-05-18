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
use Carbon\Carbon;

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
        $user = User::create(
            $request->only(
                'name',
                'email',
                'phone',
                'country',
                'city',
                'password',
                'photo',
                'year_completed',
                'house',
                'prefect',
                'prefect_title'
            )
        );

        $billingCycle = SubscriptionBillingCycle::find($request->billing_cycle);

        $beginsAt = Carbon::now();
        $expiresAt = Carbon::now()->addDays($billingCycle->days);

        if ($billingCycle) {
            $user->subscriptions()->create([
                'subscription_plan_id' => $request->membership_plan,
                'subscription_billing_cycle_id' => $request->billing_cycle,
                'begins_at' => $beginsAt,
                'expires_at' => $expiresAt
            ]);
        }
        
        return Redirect::route('subscription.payment', $user->id);
    }
}
