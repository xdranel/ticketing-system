<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Dashboard</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-black font-sans antialiased" x-data="{ sidebarOpen: true }">

<div class="min-h-screen flex flex-col">

    <header class="bg-slate-800 text-white h-20 flex items-center justify-between px-4 sticky top-0 z-30">

        <div class="flex items-center rounded hover:bg-slate-500 transition-colors">
            <button @click="sidebarOpen = !sidebarOpen"
                    type="button"
                    class="py-2 px-4">
                <i class="fa-solid fa-bars text-lg"></i>
            </button>
        </div>

        <div class="flex items-center gap-2 text-xs font-medium">

            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit"
                        class=" hover:bg-slate-500 text-white px-4 py-2 rounded transition-colors text-xs font-semibold ml-1">
                    Logout
                </button>
            </form>

        </div>
    </header>

    <div class="flex flex-1 relative overflow-hidden">
        <x-sidebar />

        <main class="flex-1 p-4 md:p-6 overflow-y-auto max-w-full ">
            {{ $slot }}
        </main>
    </div>
</div>

</body>
</html>
