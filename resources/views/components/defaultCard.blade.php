@props([
    'style' => '',
])
<div class="mx-auto p-8 rounded-lg shadow-lg {{ $style }}">
    {{$slot}}
</div>
