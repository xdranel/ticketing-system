@props([
    'label',
    'name',
    'options',
    'selected' => ''
])

<div>
    <label
        for="{{$name}}"
        class="filter-title"
    >{{$label}}</label>

    <select
        name="{{ $name }}"
        id="{{ $name }}"
        class="input-form-style"
    >
        <option value="">All {{ $label }}</option>

        @foreach($options as $option)
            <option
                value="{{$option->value}}"
                @selected($selected === $option->value)
            >
                {{str($option->name)->headline()}}
            </option>
        @endforeach
    </select>
</div>

