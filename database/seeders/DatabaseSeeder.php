<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Organization;
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionBillingCycle;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Account::truncate();

        $account = Account::create(['name' => 'Acme Corporation']);

        User::truncate();

        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'phone' => '+254720000000',
            'member' => true,
        ]);

        $membershipPlans = [
            [
                'name' => 'Associate Membership',
                'description' => 'For those currently in school or completed less than 7 years ago',
                'amount' => 1200
            ],
            [
                'name' => 'Full Membership',
                'description' => 'For those more than 7 years since completion',
                'amount' => 6000
            ],
            [
                'name' => 'Lifetime Membership',
                'description' => 'One time life membership',
                'amount' => 100000
            ],
        ];

        $billingCycles = [
            [
                'name' => 'Monthly',
                'days' => 30,
                'divisor' => 12
            ],
            [
                'name' => 'Quartely',
                'days' => 120,
                'divisor' => 4
            ],
            [
                'name' => 'Semi Annual',
                'days' => 180,
                'divisor' => 2
            ],
            [
                'name' => 'Annual',
                'days' => 365,
                'divisor' => 1
            ]
        ];

        SubscriptionPlan::truncate();
        SubscriptionBillingCycle::truncate();

        SubscriptionPlan::insert($membershipPlans);
        SubscriptionBillingCycle::insert($billingCycles);
    }
}
