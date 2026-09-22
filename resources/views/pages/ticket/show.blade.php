<x-layout>
    <x-defaultCard>
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
    </x-defaultCard>

    <x-defaultCard>
        <h2 class="text-xl font-bold">
            <span>Replies</span>
        </h2>

        <div class="mt-4 space-y-4">
            @forelse($ticket->replies as $reply)
                <div class="p-4 border rounded-lg shadow-md">
                    <div class="flex justify-between">
                        <strong>
                            {{ $reply->user->name }}
                        </strong>

                        <span class="text-sm text-gray-500">
                            {{ $reply->created_at->format('d M, Y H:i')}}
                        </span>
                    </div>

                    <p class="mt-2 whitespace-pre-line">
                        {{ $reply->message }}
                    </p>
                </div>
            @empty
                <p>No replies yet</p>
            @endforelse
        </div>

        @can('reply', $ticket)
            <form
                action="{{ route('tickets.replies.store', $ticket) }}"
                method="POST"
                class="mt-6"
            >
                @csrf

                <div>
                    <label for="message">
                        Reply
                    </label>

                    <textarea
                        name="message"
                        id="message"
                        rows="5"
                        required
                        class="w-full p-2 border rounded-lg"
                    >{{ old('message') }}</textarea>

                    @error('message')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <button type="submit">
                    Send Reply
                </button>
            </form>
        @endcan
    </x-defaultCard>
</x-layout>
