<x-layout>
    <h1 class="text-2xl font-bold">Update · {{ $ticket->reference }}</h1>

    <form
        action="{{ route('tickets.update', $ticket) }}"
        method="POST"
    >
        @csrf
        @method('PATCH')

        <x-defaultCard :style="'mt-4'">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                <div>
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
                </div>

                <div>
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
                </div>

                <div>
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
                </div>
            </div>

            <button
                type="submit"
                class="primary-btn-2 mt-4"
            >Save Changes</button>
        </x-defaultCard>
    </form>
</x-layout>
