<x-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Customer Dashboard</h1>
    </div>

    <div class="flex flex-col gap-4 mx-4">
        <strong>Your Ticket Status:</strong>

        <div class="flex gap-4 justify-between">
            <strong>Open</strong>
            <strong>In Progress</strong>
            <strong>Closed</strong>
        </div>

        <div class="flex gap-4 justify-between">
            <strong>{{ $ticketsCounts[\App\Enums\TicketStatus::Open->value] ?? 0}}</strong>
            <strong>{{ $ticketsCounts[\App\Enums\TicketStatus::InProgress->value] ?? 0}}</strong>
            <strong>{{ $ticketsCounts[\App\Enums\TicketStatus::Closed->value] ?? 0}}</strong>
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
