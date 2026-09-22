<x-layout>
    <h1 class="text-2xl font-bold">Update {{ $ticket->reference }}</h1>

    <form action="{{ route('tickets.update', $ticket) }}" method="POST">
        @csrf
        @method('PATCH')

        <label for="status">Status</label>
        <select name="status" id="status" class="input-form-style">
            @foreach(\App\Enums\TicketStatus::cases() as $status)
                <option value="{{ $status->value }}"
                    @selected(old('status', $ticket->status->value) === $status->value)>
                    {{ str($status->name)->headline() }}
                </option>
            @endforeach
        </select>
        @error('status') <p class="error">{{ $message }}</p> @enderror

        <label for="priority">Priority</label>
        <select name="priority" id="priority" class="input-form-style">
            @foreach(\App\Enums\TicketPriority::cases() as $priority)
                <option value="{{ $priority->value }}"
                    @selected(old('priority', $ticket->priority->value) === $priority->value)>
                    {{ str($priority->name)->headline() }}
                </option>
            @endforeach
        </select>
        @error('priority') <p class="error">{{ $message }}</p> @enderror

        @if(auth()->user()->role === \App\Enums\UserRole::Admin)
            <label for="assigned_to">Assigned Agent</label>
            <select name="assigned_to" id="assigned_to" class="input-form-style">
                <option value="">Unassigned</option>
                @foreach($agents as $agent)
                    <option value="{{ $agent->id }}"
                        @selected(old('assigned_to', $ticket->assigned_to) == $agent->id)>
                        {{ $agent->name }}
                    </option>
                @endforeach
            </select>
            @error('assigned_to') <p class="error">{{ $message }}</p> @enderror
        @endif

        <button type="submit">Save Changes</button>
    </form>
</x-layout>
