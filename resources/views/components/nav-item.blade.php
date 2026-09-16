@props(['href' => '#', 'active' => false])

<a href="{{ $href }}"
   class="block w-full m-0 p-10 hover:bg-slate-100 border-b border-slate-700 text-xl text-center {{$active ? 'text-red-500 bg-black font-semibold' : 'text-white bg-slate-500'}}">
    <span class="block w-full truncate">
        {{ $slot }}
    </span>
</a>



