<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
</head>

<body class="">
    <div class="bg-cover bg-center bg-fixed " style="background-image: url('{{ asset('/img/login_bg.jpg') }}')">
        <div class="bg-cover bg-center bg-fixed ">
            <div class="h-screen flex justify-center items-center">
                <div class="p-8 w-full flex justify-center items-center ">
                    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md  sm:rounded-lg">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <!-- Email Address -->
                            <div>

                                <label for="email"
                                    class='block font-medium text-sm text-gray-700 dark:text-gray-300'>
                                    {{ __('Email') }}
                                </label>

                                <input id="email" type="text" name="email" value="{{ old('email') }}"
                                    required
                                    class='block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm'>

                                @if ($errors->get('email'))
                                    <ul class='mt-2 text-sm text-red-600 dark:text-red-400 space-y-1'>
                                        @foreach ((array) $errors->get('email') as $message)
                                            <li>{{ $message }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>

                            <!-- Password -->
                            <div class="mt-4">
                                <label for="password"
                                    class='block font-medium text-sm text-gray-700 dark:text-gray-300'>
                                    {{ __('Password') }}
                                </label>

                                <input id="password" type="password" name="password" value="{{ old('email') }}"
                                    required autocomplete="current-password"
                                    class='block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm'>


                                @if ($errors->get('password'))
                                    <ul class='mt-2 text-sm text-red-600 dark:text-red-400 space-y-1'>
                                        @foreach ((array) $errors->get('password') as $message)
                                            <li>{{ $message }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>

                            <!-- Remember Me -->
                            <div class="block mt-4">
                                <label for="remember_me" class="inline-flex items-center">
                                    <input id="remember_me" type="checkbox"
                                        class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                                        name="remember">
                                    <span
                                        class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                                </label>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                @if (Route::has('password.request'))
                                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                                        href="{{ route('password.request') }}">
                                        {{ __('Forgot your password?') }}
                                    </a>
                                @endif

                                <button type="submit"
                                    class='ml-3 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150'>
                                    {{ __('Log in') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>
