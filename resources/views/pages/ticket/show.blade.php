<x-layout>
    <x-defaultCard :style="'m-4 border border-slate-900'">
        @if(session('success'))
            <x-flashMsg msg="{{session('success')}}"/>
        @endif
        <h1 class="text-2xl font-bold mb-2">{{ $ticket->subject }}</h1>
        <p class="mb-2">
            <strong>Reference:</strong>
            <span class="underline">{{ $ticket->reference }}</span>
        </p>

        <p>
            <strong>Customer:</strong> {{ $ticket->customer->name }}
        </p>

        <p class="mb-2">
            <strong>Agent:</strong> {{ $ticket->assignee?->name ?? 'Unassigned' }}
        </p>

        <p>
            <strong>Category:</strong> {{ str($ticket->category->name)->headline() }}
        </p>

        <p>
            <strong>Priority:</strong> {{ str($ticket->priority->name)->headline() }}
        </p>

        <p class="mb-2">
            <strong>Status:</strong> {{ str($ticket->status->name)->headline() }}
        </p>

        <p class="mb-2">
            <strong>Description:</strong> <br/>{{ $ticket->description }}
        </p>
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
            <a href="{{ route('tickets.edit', $ticket) }}"
               class="primary-btn-2 mt-4 inline-block text-center"
            >Update Workflow</a>
        @endcan

        @can('delete', $ticket)
            <form action="{{ route('tickets.destroy', $ticket) }}" method="POST">
                @csrf
                @method('DELETE')
                <button
                    type="submit"
                    class="primary-btn-2 mt-4"
                >Delete</button>
            </form>
        @endcan
    </x-defaultCard>

    <x-defaultCard :style="'m-4 border border-slate-900'">
        <h1 class="normal-title">
            <span>Replies</span>
        </h1>
        <div class="mt-4 border-t border-slate-600 space-y-4"></div>


        <div class="mt-4 space-y-4">
            @forelse($ticket->replies as $reply)

                <div class="flex {{ $reply->is_mine ? 'justify-end' : 'justify-start' }} ">

                    <div
                        class="max-w-l p-4 border border-slate-600 rounded-lg {{ $reply->is_mine ? 'bg-indigo-900 text-white' : 'bg-white text-slate-900' }}">

                        <div class="flex justify-between items-center">
                            <strong>
                                {{ $reply->user->name }}
                                @if($reply->is_mine)
                                    <span class="text-xs font-normal opacity-75">(You)</span>
                                @endif
                            </strong>
                            &nbsp;
                            <span class="text-sm {{ $reply->is_mine ? 'text-indigo-200' : 'text-slate-500' }}">
                                {{ $reply->created_at->format('d M, Y H:i')}}
                            </span>
                        </div>

                        <p class="mt-2 whitespace-pre-line">
                            {{ $reply->message }}
                        </p>
                    </div>
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
                    <label for="message"
                           class="block text-sm font-bold text-slate-900 mb-2"
                    >
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

                <button
                    type="submit"
                    class="primary-btn-2 mt-4"
                >
                    Send Reply
                </button>
            </form>
        @endcan
    </x-defaultCard>

    @if(auth()->user()->role === \App\Enums\UserRole::Admin)
        <x-defaultCard :style="'m-4'">
            <div x-data="{ open: false }">

                <button
                    @click="open = !open"
                    class="w-full flex items-center justify-between text-left focus:outline-none group cursor-pointer py-2">

                    <h3 class="text-lg font-semibold text-slate-800 group-hover:text-slate-400 transition-colors">
                        Activities Timeline
                    </h3>

                    <!-- Rotating Arrow Icon -->
                    <svg
                        :class="{ 'rotate-90': open }"
                        class="w-5 h-5 text-gray-500 transform transition-transform duration-200"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>

                <div x-show="open"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     class="mt-4 pt-4 border-t border-slate-600 space-y-4"
                >
                    @forelse ($activities as $activity)
                        <div class="border-start border-3 ps-3 mb-4">

                            <div class="d-flex justify-content-between">
                                <strong>
                                    {{ $activity->actor_name }}
                                </strong>

                                <small class="text-muted">
                                    {{ $activity->created_at?->format('d M Y H:i') }}
                                </small>
                            </div>

                            <div class="mt-1">
                                {{ $activity->description }}
                            </div>

                            <small class="text-muted">
                                {{ $activity->action }}
                            </small>

                        </div>
                    @empty
                        <p class="text-muted mb-0">
                            No activity recorded yet.
                        </p>
                    @endforelse
                </div>
            </div>
        </x-defaultCard>
    @endif
</x-layout>
