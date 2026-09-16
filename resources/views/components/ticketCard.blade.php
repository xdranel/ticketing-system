@props([
    'grid' => '',
    'ticket' => null,
])

{{--<div class="mx-auto p-8 rounded-lg shadow-lg {{$grid}}">--}}
{{--    @if($ticket)--}}
{{--        <h2 class="text-lg font-semibold">{{ $ticket->subject }}</h2>--}}
{{--        <p class="text-slate-600">{{ $ticket->description }}</p>--}}
{{--    @else--}}
{{--        No Ticket Found--}}
{{--    @endif--}}
{{--</div>--}}


<div class="mx-auto p-8 rounded-lg shadow-lg {{ $grid }}">
    @if($ticket)
        <h2 class="text-2xl font-bold">{{ $ticket->subject }}</h2>
        <p>{{ $ticket->reference }} ·
            <span
                class="@if($ticket->status === App\Enums\TicketStatus::Open) text-slate-100 bg-green-500
                @elseif($ticket->status === App\Enums\TicketStatus::InProgress) text-slate-100 bg-yellow-500
                @elseif($ticket->status === App\Enums\TicketStatus::Closed) text-slate-00 bg-red-500 @endif rounded-full px-2 py-1">
        {{ $ticket->status->name }}
    </span>
        </p>
        <p class="text-slate-600">{{ $ticket->description }}</p>
        @can('view', $ticket)
            <a href="{{ route('tickets.show', $ticket) }}">View Ticket</a>
        @endcan
    @else
        {{ $slot }}
    @endif
</div>
