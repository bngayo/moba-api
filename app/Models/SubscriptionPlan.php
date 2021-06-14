<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubscriptionPlan extends Model
{
    use HasFactory;

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function scopeOrderByFee($query)
    {
        $query->orderBy('amount');
    }
}
