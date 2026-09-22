<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customer = User::whereIn('email', [
            'customer1@example.com',
            'customer2@example.com',
            'customer3@example.com'
        ])->get();
//        $agent = User::factory()->create();

        Ticket::factory()
            ->count(100)
            ->make()
            ->each(function (Ticket $ticket) use ($customer) {
                $ticket->customer_id = $customer->random()->id;
                $ticket->save();
            });

//        Ticket::factory()
//            ->count(20)
//            ->make()
//            ->each(function (Ticket $ticket) use ($customer, $agent) {
//                $ticket->customer_id = $customer->id;
//                $ticket->assigned_to = $agent->id;
//                $ticket->save();
//            });

    }
}
