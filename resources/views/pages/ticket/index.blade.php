<x-layout>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold">Tickets</h1>

        </div>

        <div>
            @can('create', \App\Models\Ticket::class)
                <a href="{{ route('tickets.create') }}" class="primary-btn-1">Create Ticket</a>
            @endcan
        </div>
    </div>

    @if(session('success'))
        <x-flashMsg msg="{{session('success')}}"/>
    @endif

    @forelse($tickets as $ticket)
        <x-ticketCard :ticket="$ticket"/>
    @empty
        <p>No tickets found.</p>
    @endforelse

    {{ $tickets->links() }}
</x-layout>
