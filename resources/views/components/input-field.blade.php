@props([
    'label',
    'type' => 'text',
    'placeholder' => '',
    'icon' => null,
    'value' => '',
    'required' => '',
    'styles' => '',
])

<div>
    <label
        for="{{$label}}"
        class="block text-sm font-medium text-slate-900"
    >{{ $label }}</label>

    <div class="relative mt-1 rounded-md">
        @if($icon)
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <span class="grid place-content-center text-sm text-slate-400">
                    <i class="fa-solid fa-{{ $icon }}"></i>
                </span>
            </div>
        @endif
        <input
            type="{{ $type }}"
            name="{{ strtolower($label) }}"
            id="{{ $label }}"
            value="{{ $value }}"
            placeholder="{{ $placeholder }}"
            class="input-form-style {{$styles}} {{$icon ? 'pl-9' : 'pl-3'}}"
        />
    </div>
</div>
