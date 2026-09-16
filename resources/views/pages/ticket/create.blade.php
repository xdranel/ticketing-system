@use('App\Enums\TicketCategory')
@use('App\Enums\TicketPriority')

<x-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Create Support Ticket</h1>
    </div>

    <form action="{{route('tickets.store')}}" method="post" enctype="multipart/form-data">
        @csrf

        <x-ticketCard :grid="'grid grid-cols-1 md:grid-cols-6 gap-6 bg-white'">

            @if(auth()->user()->role === \App\Enums\UserRole::Admin)
                <label for="customer_id">Customer</label>
                <select name="customer_id" id="customer_id" class="input-form-style">
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" @selected(old('customer_id') == $customer->id)>
                            {{ $customer->name }} ({{ $customer->email }})
                        </option>
                    @endforeach
                </select>
                @error('customer_id') <p class="error">{{ $message }}</p> @enderror
            @endif

            <div class="md:col-span-4">
                <x-input-field
                    :label="'Subject'"
                    :placeholder="'Enter the subject of your ticket...'"
                    value="{{old('subject')}}"
                ></x-input-field>
                @error('subject')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-1">
                <label for="category" class="block text-sm font-medium text-slate-900">Category</label>
                <select name="category" id="category" class="input-form-style cursor-pointer">
                    @foreach(TicketCategory::cases() as $category)
                        <option value="{{ $category->value }}" {{ old('category') === $category->value ? 'selected' : '' }}>
                            {{ ucfirst($category->name) }}
                        </option>
                    @endforeach
                </select>
                @error('category')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-1">
                <label for="priority" class="block text-sm font-medium text-slate-900">Priority</label>
                <select name="priority" id="priority" class="input-form-style cursor-pointer">
                    @foreach(TicketPriority::cases() as $priority)
                        <option value="{{ $priority->value }}" {{ old('priority', TicketPriority::Low->value) === $priority->value ? 'selected' : '' }}>
                            {{ ucfirst($priority->name) }}
                        </option>
                    @endforeach
                </select>
                @error('priority')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="col-span-full">
                <label for="description" class="block text-sm font-medium text-slate-900">Description</label>
                <textarea
                    name="description"
                    id="description"
                    rows="5"
                    placeholder="Provide detailed information regarding your inquiry..."
                    class="input-form-style resize-y"
                >{{ old('description') }}</textarea>
                @error('description')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-3">
                <label for="attachment" class="block text-sm font-medium text-slate-900">Attachment (optional)</label>
                <input
                    type="file"
                    name="attachments[]"
                    id="attachments"
                    class="input-form-style file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 cursor-pointer"
                />
                @error('attachment')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="col-span-full flex justify-end pt-4 border-t border-slate-100">
                <button type="submit" class="primary-btn-1 md:w-48">
                    Submit Ticket
                </button>
            </div>

        </x-ticketCard>
    </form>
</x-layout>
