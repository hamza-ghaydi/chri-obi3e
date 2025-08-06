<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
@vite(['resources/css/app.css', 'resources/js/app.js'])
<body>
    
    <div class="flex items-center justify-center h-screen w-full">

        {{-- Main Card Container --}}
        <div class="relative flex flex-col h-screen space-y-8 bg-white shadow-2xl rounded-2xl md:flex-row md:space-y-0">
            
            <div class="w-full p-8 md:p-12 md:w-1/2">
                
                {{-- Top right link to Login Page --}}
                <div class="text-right">
                     <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-bold text-brand-dark bg-gray-200 rounded-full hover:bg-gray-300">
                        Login
                    </a>
                </div>

                <h1 class="text-2xl font-bold mt-8 text-brand-dark">Create Your Account</h1>
                <p class="text-sm text-gray-600">Join Chriwbi3 and start your journey today.</p>

                <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-2">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-semibold text-brand-dark">{{ __('Full Name') }}</label>
                        <x-text-input id="name" class="block w-full px-4 py-3 mt-1 border-gray-300 rounded-full shadow-sm focus:ring-primary focus:border-primary" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <label for="email" class="block text-sm font-semibold text-brand-dark">{{ __('Email Address') }}</label>
                        <x-text-input id="email" class="block w-full px-4 py-3 mt-1 border-gray-300 rounded-full shadow-sm focus:ring-primary focus:border-primary" type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    
                    <div class="mt-4">
                        <label class="block text-sm font-semibold text-brand-dark">{{ __('Account Type') }}</label>
                        <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="shadow-lg text-[#cba660]  rounded-lg">
                                <input id="role_client" name="role" type="radio" value="client" class="sr-only peer" {{ old('role', 'client') == 'client' ? 'checked' : '' }}>
                                <label for="role_client" class="block p-4 text-center border-2 border-gray-300 rounded-lg cursor-pointer transition-all peer-checked:border-primary peer-checked:ring-2 peer-checked:ring-primary peer-checked:bg-primary/10 hover:border-primary/50">
                                    
                                    <p class="mt-2 font-semibold text-2xl">Client</p>
                                    <p class="text-xs text-gray-500">I want to buy or rent.</p>
                                </label>
                            </div>
                             <div class="shadow-lg text-[#cba660]  rounded-lg">
                                <input id="role_owner" name="role" type="radio" value="owner" class="sr-only peer" {{ old('role') == 'owner' ? 'checked' : '' }}>
                                <label for="role_owner" class="block p-4 text-center border-2 border-gray-300 rounded-lg cursor-pointer transition-all peer-checked:border-primary peer-checked:ring-2 peer-checked:ring-primary peer-checked:bg-primary/10 hover:border-primary/50">
                                    
                                    <p class="mt-2 font-semibold text-2xl">Property Owner</p>
                                    <p class="text-xs text-gray-500">I want to sell or list.</p>
                                </label>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>


                    <div class="mt-4">
                        <label for="password" class="block text-sm font-semibold text-brand-dark">{{ __('Password') }}</label>
                        <x-text-input id="password" class="block w-full px-4 py-3 mt-1 border-gray-300 rounded-full shadow-sm focus:ring-primary focus:border-primary" type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <label for="password_confirmation" class="block text-sm font-semibold text-brand-dark">{{ __('Confirm Password') }}</label>
                        <x-text-input id="password_confirmation" class="block w-full px-4 py-3 mt-1 border-gray-300 rounded-full shadow-sm focus:ring-primary focus:border-primary" type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="mt-6">
                        <button type="submit"
                                class="w-full px-4 py-3 font-bold bg-[#cba660]  text-white bg-primary rounded-full hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            {{ __('Register') }}
                        </button>
                    </div>

                    <div class="text-center">
                        <a class="text-sm text-gray-600 hover:text-brand-dark hover:underline rounded-md" href="{{ route('login') }}">
                            {{ __('Already registered? Login') }}
                        </a>
                    </div>
                </form>

            </div>

            <div class="relative md:w-1/2 ">
                <img src="https://images.pexels.com/photos/280222/pexels-photo-280222.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
                     alt="Image of a modern house"
                     class="object-cover w-full h-full hidden md:block">
                
                {{-- Text Overlay --}}
                <div 
                    class="absolute inset-0 bg-black/70 hidden md:flex flex-col justify-between p-8 text-white">
                    <div class="flex items-center text-[#cba660]">
                        <svg class="w-8 h-8 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" /></svg>
                        <span class="text-xl font-bold">Chriwbi3</span>
                    </div>
                    <div class="mt-auto">
                        <h2 class="text-3xl font-extrabold leading-tight">Join a Community of Buyers and Sellers</h2>
                        <p class="mt-2 text-gray-200">
                           Find your dream home or list your property for thousands to see. Your real estate journey starts here.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>
</html>