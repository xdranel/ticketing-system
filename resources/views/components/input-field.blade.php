@props([
    'label',
    'name' => '',
    'type' => 'text',
    'placeholder' => '',
    'icon' => null,
    'value' => '',
    'required' => '',
    'styles' => '',
])

<div>
    <label
        for="{{ $name }}"
        class="filter-title"
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
            name="{{ $name }}"
            id="{{ $name }}"
            value="{{ $value }}"
            placeholder="{{ $placeholder }}"
            class="input-form-style {{$styles}} {{$icon ? 'pl-9' : 'pl-3'}}"
        />
    </div>
</div>
