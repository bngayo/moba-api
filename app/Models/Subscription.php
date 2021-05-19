<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Subscription extends Model
{
    use HasFactory;

    protected $with = ['subscription_plan', 'subscription_billing_cycle'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscription_plan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    public function subscription_billing_cycle()
    {
        return $this->belongsTo(SubscriptionBillingCycle::class);
    }

    public function scopeActive($query)
    {
        $query->where('expires_at', '>=', Carbon::now())->latest();
    }
}
