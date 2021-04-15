<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Organization;
use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $account = Account::create(['name' => 'Acme Corporation']);

        User::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'phone' => '+254720000000',
            'member' => true,
        ]);

        SubscriptionPlan::createMany(
            [
                'description' => 'Monthly',
                'days' => 30,
                'fee' => 500
            ],
            [
                'description' => 'Quartely',
                'days' => 120,
                'fee' => 1500
            ],
            [
                'description' => 'Semi Annual',
                'days' => 180,
                'fee' => 3000
            ],
            [
                'description' => 'Annual',
                'days' => 365,
                'fee' => 6000
            ]
        );

        // User::factory()->count(5)->create([
        //     'account_id' => $account->id
        // ]);

        // $organizations = Organization::factory()->count(100)->create([
        //     'account_id' => $account->id
        // ]);

        // Contact::factory()->count(100)->create([
        //     'account_id' => $account->id
        // ])
        //     ->each(function (Contact  $contact) use ($organizations) {
        //         $contact->update(['organization_id' => $organizations->random()->id]);
        //     });
    }
}
