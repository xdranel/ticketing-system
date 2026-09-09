<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="m-0 p-0">

<div class="flex h-screen w-screen overflow-hidden">

    <div class="hidden lg:flex lg:w-3/4 flex-col justify-between bg-slate-600 p-12 text-white h-full">
        <div></div>

        <div class="max-w-md">
            <h1 class="text-4xl font-bold tracking-tight">Ticketing System</h1>
        </div>

        <div></div>
    </div>

    <div class="flex flex-col justify-center px-6 py-12 w-full lg:w-1/2 lg:px-20 bg-white h-full">
        <div class="mx-auto w-full max-w-sm">

            <div class="mb-8">
                <h2 class="text-2xl font-bold">Login To Your Account</h2>
            </div>

            @error('failed')
            <x-flashMsg :msg="$message" bg="bg-red-500" />
            @enderror

            <form action="{{ route('login') }}" method="post">
                @csrf
                <div class="mb-4">
                    <label for="email">Email</label>
                    <input type="text"
                           name="email"
                           value="{{ old('email') }}"
                           class="input-form-style"
                    />
                    @error('email')
                    <p class="error">{{$message}}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password">Password</label>
                    <input type="password"
                           name="password"
                           class="input-form-style"/>
                    @error('password')
                    <p class="error">{{$message}}</p>
                    @enderror
                </div>

                <div class="pt-2">
                    <button type="submit"
                            class="primary-btn-1">
                        Log In
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
