<x-layout>
    @if(session('success'))
        <x-flashMsg msg="{{session('success')}}"/>
    @endif
    <h1 class="text-2xl font-bold">{{ $ticket->subject }}</h1>
    <p>Reference: {{ $ticket->reference }}</p>
    <p>Customer: {{ $ticket->customer->name }}</p>
    <p>Agent: {{ $ticket->assignee?->name ?? 'Unassigned' }}</p>
    <p>Category: {{ str($ticket->category->name)->headline() }}</p>
    <p>Priority: {{ str($ticket->priority->name)->headline() }}</p>
    <p>Status: {{ str($ticket->status->name)->headline() }}</p>
    <p>Description: <br/>{{ $ticket->description }}</p>
    <strong>Attachments:</strong>
        @forelse($ticket->attachments as $attachment)
            <div class="flex items-center gap-2">
                <span>{{$attachment->name}}</span>

                <a
                    href="{{ route('ticket-attachments.download', $attachment) }}"
                    target="_blank"
                    class="text-blue-500 hover:underline"
                >
                Download
                </a>
            </div>
        @empty
            <p>No Attachments</p>
        @endforelse

    @can('update', $ticket)
        <a href="{{ route('tickets.edit', $ticket) }}">Update Workflow</a>
    @endcan

    @can('delete', $ticket)
        <form action="{{ route('tickets.destroy', $ticket) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">Delete</button>
        </form>
    @endcan
</x-layout>
