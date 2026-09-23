<x-layout>
    <div class="flex flex-col gap-8 mx-4">
        <p class="text-2xl font-bold text-slate-800">Your Ticket Status:</p>

        <div class="rounded-lg bg-blue-300 p-4">
            <p class="text-sm text-slate-700">
                Total Assigned Tickets
            </p>
            <p class="text-3xl font-bold text-slate-800">
                {{ $totalTickets }}
            </p>
        </div>

        <div class="rounded-lg bg-green-300 p-4">
            <p class="text-sm text-slate-700">
                Open Tickets
            </p>
            <p class="text-3xl font-bold text-slate-800">
                {{$ticketsCounts[\App\Enums\TicketStatus::Open->value] ?? 0}}
            </p>
        </div>

        <div class="rounded-lg bg-yellow-300 p-4">
            <p class="text-sm text-slate-700">
                In Progress Tickets
            </p>
            <p class="text-3xl font-bold text-slate-800">
                {{$ticketsCounts[\App\Enums\TicketStatus::InProgress->value] ?? 0}}
            </p>
        </div>

        <div class="rounded-lg bg-red-300 p-4">
            <p class="text-sm text-slate-700">
                Closed Tickets
            </p>
            <p class="text-3xl font-bold text-slate-800">
                {{ $ticketsCounts[\App\Enums\TicketStatus::Closed->value] ?? 0 }}
            </p>
        </div>
        {{--        <div class="flex-1 flex-col gap-4 w-full">--}}
        {{--            @forelse($tickets as $ticket)--}}
        {{--                <x-ticketCard :ticket="$ticket" />--}}
        {{--            @empty--}}
        {{--                <p class="text-slate-500">No tickets found.</p>--}}
        {{--            @endforelse--}}
        {{--        </div>--}}
    </div>
</x-layout>
