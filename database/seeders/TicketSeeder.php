<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Storage::disk('public')->deleteDirectory('ticket-attachments-dummy');

        $customer = User::whereIn('email', [
            'customer1@example.com',
            'customer2@example.com',
            'customer3@example.com'
        ])->get();
        $agent = User::whereIn('email', [
            'agent1@example.com',
            'agent2@example.com'
        ])->get();

//        Ticket::factory()
//            ->count(100)
//            ->make()
//            ->each(function (Ticket $ticket) use ($customer) {
//                $ticket->customer_id = $customer->random()->id;
//                $ticket->save();
//            });

        Ticket::factory()
            ->count(50)
            ->make()
            ->each(function (Ticket $ticket) use ($customer, $agent) {
                $ticket->customer_id = $customer->random()->id;
                $ticket->assigned_to = $agent->random()->id;
                $ticket->save();

                TicketAttachment::factory()
                    ->create([
                        'ticket_id' => $ticket->id,
                    ]);
            });


    }

}
