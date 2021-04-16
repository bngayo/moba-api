<?php

namespace App\Http\Controllers\API;

use App\Models\SubscriptionPlan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\SubscriptionPlanCollection;

class SubscriptionPlanController extends Controller
{
    public function index()
    {
        $plans = new SubscriptionPlanCollection(
            SubscriptionPlan::orderByFee()->get()
        );

        return $plans;
    }
}
