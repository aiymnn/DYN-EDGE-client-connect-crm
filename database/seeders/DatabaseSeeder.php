<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Interaction;
use App\Models\Ticket;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Customer::factory(50)->create();

        $users = User::where('role', 'R02')->get();
        $customers = Customer::all();

        Interaction::factory(100)->make()->each(function ($interaction) use ($users, $customers) {
            $interaction->user_id = $users->random()->id;
            $interaction->customer_id = $customers->random()->id;
            $interaction->save();
        });

        Ticket::factory(100)->make()->each(function ($ticket) use ($users, $customers) {
            $ticket->customer_id = $customers->random()->id;
            $ticket->user_id = $users->random()->id;
            $ticket->save();
        });
    }
}
