<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>


    <div class="flex items-center justify-center min-h-screen bg-[#2F2B40]">

        {{-- Main Card Container --}}
        <div class="relative flex space-y-8 bg-white shadow-2xl rounded-2xl md:flex-row md:space-y-0 ">

            <div class="relative md:w-1/2">
                <img src="https://images.pexels.com/photos/101808/pexels-photo-101808.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
                    alt="" class="object-cover w-full h-full rounded-l-2xl hidden md:block">

                {{-- Text Overlay with your brand's dark color --}}
                <div
                    class="absolute inset-0 bg-black/70 rounded-l-2xl hidden md:flex flex-col justify-between p-8 text-white">
                    <div class="flex items-center text-[#cba660]">

                        <svg class="w-8 h-8 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
                        </svg>
                        <span class="text-xl font-bold">Chriwbi3</span>
                    </div>
                    <div class="mt-auto">
                        <h2 class="text-3xl font-extrabold leading-tight">Manage Properties Efficiently</h2>
                        <p class="mt-2 text-gray-200">
                            Easily track rent payments, maintenance requests, and tenant communications in one place.
                            Say goodbye to the hassle of manual management.
                        </p>
                    </div>
                </div>
            </div>

            <div class="w-full p-8 md:p-12 md:w-1/2">

                {{-- Top right link to Register Page --}}
                <div class="text-right">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 text-sm font-bold text-brand-dark bg-gray-200 rounded-full hover:bg-gray-300">
                            Register
                        </a>
                    @endif
                </div>
                <br><br>
                <h1 class="text-2xl font-bold mt-8 text-brand-dark">Welcome Back to Chriwbi3!</h1>
                <p class="text-sm text-gray-600">Sign in to your account</p>

                <x-auth-session-status class="my-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-5">
                    @csrf

                    <div>
                        <label for="email"
                            class="block text-sm font-semibold text-brand-dark">{{ __('Your Email') }}</label>
                        <x-text-input id="email"
                            class="block w-full px-4 py-3 mt-1 border-gray-300 rounded-full shadow-sm focus:ring-primary focus:border-primary"
                            type="email" name="email" :value="old('email')" required autofocus
                            autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <label for="password"
                            class="block text-sm font-semibold text-brand-dark">{{ __('Password') }}</label>
                        <div class="relative">
                            <x-text-input id="password"
                                class="block w-full px-4 py-3 mt-1 border-gray-300 rounded-full shadow-sm focus:ring-primary focus:border-primary"
                                type="password" name="password" required autocomplete="current-password" />
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.036 12.322a1.012 1.012 0 0 1 0-.639l4.436-7.104a1.012 1.012 0 0 1 1.591 0l4.436 7.104a1.012 1.012 0 0 1 0 .639l-4.436 7.104a1.012 1.012 0 0 1-1.591 0l-4.436-7.104Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox"
                                class="text-primary border-gray-300 rounded shadow-sm focus:ring-primary"
                                name="remember">
                            <span class="ms-2 text-sm text-gray-600">{{ __('Remember Me') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm text-gray-600 hover:text-brand-dark hover:underline rounded-md"
                                href="{{ route('password.request') }}">
                                {{ __('Forgot Password?') }}
                            </a>
                        @endif
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="w-full px-4 py-3 font-bold text-white bg-[#cba660] rounded-full ">
                            {{ __('Login') }}
                        </button>
                    </div>
                </form>
            </div>

            </div>
        </div>
    </div>

</body>

</html>
