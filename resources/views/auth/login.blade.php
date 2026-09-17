<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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

    <div class="flex flex-col justify-center px-4 py-12 w-full lg:w-1/3 lg:px-20 bg-white h-full">
        <div>

            <div class="mb-8">
                <h2 class="text-2xl font-bold">Login To Your Account</h2>
            </div>

            @error('failed')
            <x-flashMsg :msg="$message" bg="bg-red-500"/>
            @enderror

            <form action="{{ route('login') }}" method="post">
                @csrf
                <div class="mb-4">
                    <x-input-field :label="'Email'" :name="'email'" value="{{old('email')}}" :icon="'at'"
                                   :placeholder="'Enter your email'"/>
                    @error('email')
                    <p class="error">{{$message}}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <x-input-field :label="'Password'" :name="'password'" :type="'password'" :icon="'key'"
                                   :placeholder="'Enter your password'"/>
                    @error('password')
                    <p class="error">{{$message}}</p>
                    @enderror
                </div>

                <div class="mb-4 flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" class="mr-1" name="remember" id="remember"/>
                        <label for="remember">Remember Me</label>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="primary-btn-1">
                        Log In
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
