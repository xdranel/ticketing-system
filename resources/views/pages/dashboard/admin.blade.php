<x-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Admin Dashboard</h1>
    </div>

    <div>
        <div class="flex-1 flex-col gap-4 w-full">
            @forelse($tickets as $ticket)
                <x-ticketCard :ticket="$ticket" />
            @empty
                <p class="text-slate-500">No tickets found.</p>
            @endforelse
        </div>
    </div>
</x-layout>
