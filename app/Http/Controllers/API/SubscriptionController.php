<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\SubscriptionBillingCycle;
use Illuminate\Http\Request;
use App\Http\Requests\API\SubscriptionRequest;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    public function store(User $user, SubscriptionRequest $request)
    {
        $subscription = $request->validated();

        $plan = SubscriptionBillingCycle::findOrFail($subscription['subscription_billing_cycle_id']);

        $currentDate = Carbon::now();
        $expiryDate = Carbon::now();

        if ($plan->divisor == 12) {
            $expiryDate = $expiryDate->addMonth();
        } elseif ($plan->divisor == 4) {
            $expiryDate = $expiryDate->addQuarter();
        } elseif ($plan->divisor == 2) {
            $expiryDate = $expiryDate->subYear();
        } elseif ($plan->divisor == 1) {
            $expiryDate = $expiryDate->addYear();
        }

        $subscription['begins_at'] = $currentDate;
        $subscription['expires_at'] = $expiryDate;

        $user->subscriptions()->create(
            $subscription
        );

        return $this->sendResponse([], 'Your subscription has been successfully processed.');
    }
}
