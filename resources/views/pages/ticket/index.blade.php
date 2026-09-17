<x-layout>
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-4">
            <h1 class="text-2xl font-bold">Tickets</h1>
            @can('create', \App\Models\Ticket::class)
                <a href="{{ route('tickets.create') }}" class="primary-btn-1">Create Ticket</a>
            @endcan
        </div>

        <div>
            <form
                action="{{ route('tickets.index') }}"
                method="GET"
                class="grid grid-cols-1 md:grid-cols-5 gap-4"
            >
                <div>
                    <x-input-field
                        :label="'Search'"
                        :name="'search'"
                        value="{{request('search')}}"
                        :placeholder="'Search subject or description or ticket number'"
                    />
                </div>

                <div>
                    <x-input-filter
                        :label="'Category'"
                        :name="'category'"
                        :options="\App\Enums\TicketCategory::cases()"
                        :selected="request('category')"
                    />
                </div>

                <div>
                    <x-input-filter
                        :label="'Priority'"
                        :name="'priority'"
                        :options="\App\Enums\TicketPriority::cases()"
                        :selected="request('priority')"
                    />
                </div>

                <div>
                    <x-input-filter
                        :label="'Status'"
                        :name="'status'"
                        :options="\App\Enums\TicketStatus::cases()"
                        :selected="request('status')"
                    />
                </div>

                <div class="flex items-end gap-2">
                    <button
                        type="submit"
                        class="primary-btn-1"
                    >Apply</button>
                    <a href="{{ route('tickets.index') }}" class="secondary-btn-1">Reset</a>
                </div>

            </form>
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
