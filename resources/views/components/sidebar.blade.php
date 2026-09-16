<aside x-show="sidebarOpen"
       x-transition:enter="transition ease-out duration-200"
       x-transition:enter-start="-translate-x-full"
       x-transition:enter-end="translate-x-0"
       x-transition:leave="transition ease-in duration-150"
       x-transition:leave-start="translate-x-0"
       x-transition:leave-end="-translate-x-full"
       class="w-64 bg-slate-500 text-slate-200 flex flex-col shrink-0 min-h-screen border-r border-slate-800 shadow-xl z-20">

    <div class="w-full p-4 bg-slate-500 flex flex-col items-center text-center border-b border-slate-700">
        <h3 class="font-bold text-sm text-white tracking-wide">
            {{ auth()->user()->name }}
        </h3>

        <div class="mt-2 inline-block px-3 py-1 bg-slate-800 border border-slate-600 text-[10px] font-semibold text-slate-300 uppercase tracking-wider rounded">
            {{ auth()->user()->role->value }}
        </div>
    </div>

    <nav class="w-full m-0 p-0">
        <ul class="w-full m-0 p-0 list-none">
            @auth
                @includeIf('components.partials.' . auth()->user()->role->value)
            @endauth
        </ul>
    </nav>
</aside>
