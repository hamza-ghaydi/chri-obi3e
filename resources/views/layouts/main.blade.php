<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ChriwBi3</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="font-sans antialiased">
    <!-- Navigation -->
    
    <nav class="bg-[#2F2B40] shadow-lg border-b border-[#CBA660]/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <!-- Logo -->
                    <a href="{{ route('home') }}" class="flex items-center group">
                        <i
                            class="fas fa-home text-[#CBA660] text-2xl mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                        <span
                            class="text-white text-xl font-bold group-hover:text-[#CBA660] transition-colors duration-200">RealEstate</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="flex items-center space-x-8 justify-center w-full">
                    <div class="space-x-8 w-full px-[10vw]">
                        <a href="{{ route('home') }}"
                            class="text-white active:text-[#CBA660] {{ request()->routeIs('home') ? 'nav-link-active-new' : '' }}">
                            Home
                        </a>
                        <a href="{{ route('home') }}#about-us" class="text-white active:text-[#CBA660]">
                            About us
                        </a>
                        <a href="{{ route('home') }}#properties" class="text-white active:text-[#CBA660]">
                            Properties
                        </a>
                        <a href="{{ route('home') }}#list-property" class="text-white active:text-[#CBA660]">
                            List your property
                        </a>
                    </div>
                    @auth
                        {{-- drop down ila kan m auth --}}
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center text-[#CBA660] hover:text-brand-beige w-[10vw]">
                                <span>{{ auth()->user()->name }}</span>
                                <i class="fas fa-chevron-down ml-1"></i>
                            </button>
                            
                            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                @if(auth()->user()->isClient())
                                    <a href="{{ route('client.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                                    <a href="{{ route('client.favorites.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Favorites</a>
                                    <a href="{{ route('client.appointments.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Appointments</a>
                                @elseif(auth()->user()->isOwner())
                                    <a href="{{ route('owner.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                                    <a href="{{ route('owner.properties.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Properties</a>
                                    <a href="{{ route('owner.properties.create') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Add Property</a>
                                @elseif(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Admin Dashboard</a>
                                @endif
                                <div class="border-t border-gray-100"></div>
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="border px-4 py-1.5 rounded-lg bg-[#CBA660] text-white hover:bg-opacity-90 transition duration-300">Login</a>
                        <a href="{{ route('register') }}" class="border px-4 py-1.5 rounded-lg text-white hover:bg-[#CBA660] transition duration-300 ">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="bg-green-50 border-l-4 border-green-400 text-green-800 px-6 py-4 mx-4 mt-4 rounded-r-lg shadow-sm"
            role="alert">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-3 text-green-500"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-50 border-l-4 border-red-400 text-red-800 px-6 py-4 mx-4 mt-4 rounded-r-lg shadow-sm"
            role="alert">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-3 text-red-500"></i>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    {{-- footer --}}
    <footer class="bg-[#2F2B40] text-white">

        <div class="max-w-7xl mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">


                <div class="lg:col-span-1">
                    <div class="mb-6">
                        {{-- logo --}}
                        <h3 class="text-2xl font-bold text-[#CBA660] mb-4">ChriWBi3</h3>
                        <p class="text-gray-300 text-sm leading-relaxed">
                            Your trusted real estate platform in Morocco. Find your dream property or list your property
                            with ease. We connect buyers, sellers, and renters across the country.
                        </p>
                    </div>

                    <!-- Social Media Links -->
                    <div class="flex space-x-4">
                        <a href="#"
                            class="bg-[#CBA660] p-3 rounded-full transition-colors duration-300 items-center flex justify-center w-10 h-10">
                            <i class="fab fa-facebook-f text-sm"></i>
                        </a>
                        <a href="#"
                            class="bg-[#CBA660] p-3 rounded-full transition-colors duration-300 items-center flex justify-center w-10 h-10">
                            <i class="fab fa-twitter text-sm"></i>
                        </a>
                        <a href="#"
                            class="bg-[#CBA660] p-3 rounded-full transition-colors duration-300 items-center flex justify-center w-10 h-10">
                            <i class="fab fa-instagram text-sm"></i>
                        </a>
                        <a href="#"
                            class="bg-[#CBA660] p-3 rounded-full transition-colors duration-300 items-center flex justify-center w-10 h-10">
                            <i class="fab fa-linkedin-in text-sm"></i>
                        </a>
                        <a href="#"
                            class="bg-[#CBA660] p-3 rounded-full transition-colors duration-300 items-center flex justify-center w-10 h-10">
                            <i class="fab fa-whatsapp text-sm"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="text-center">
                    <h4 class="text-lg font-semibold mb-6 text-[#CBA660]">Quick Links</h4>
                    <ul class="space-y-3 ">
                        <li>
                            <a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">
                                Properties
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">
                                For Sale
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">
                                For Rent
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">
                                About Us
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">
                                Contact
                            </a>
                        </li>
                    </ul>
                </div>



                <!-- Contact Info -->
                <div class="text-center">
                    <h4 class="text-lg font-semibold mb-6 text-[#CBA660]">Contact Info</h4>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <i class="fas fa-map-marker-alt text-[#CBA660] mt-1 mr-3"></i>
                            <div class="">
                                <p class="text-gray-300 text-sm ">
                                    123 Hassan II Boulevard
                                    Casablanca, Morocco
                                    20000
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <i class="fas fa-phone text-[#CBA660] mr-3"></i>
                            <a href="tel:+212522123456"
                                class="text-gray-300 hover:text-white transition-colors duration-200 text-sm">
                                +212 522 123 456
                            </a>
                        </div>

                        <div class="flex items-center">
                            <i class="fas fa-envelope text-[#CBA660] mr-3"></i>
                            <a href="mailto:info@chriwbi3.com"
                                class="text-gray-300 hover:text-white transition-colors duration-200 text-sm">
                                info@chriwbi3.com
                            </a>
                        </div>

                        <div class="flex items-center">
                            <i class="fab fa-whatsapp text-[#CBA660] mr-3"></i>
                            <a href="https://wa.me/212522123456"
                                class="text-gray-300 hover:text-white transition-colors duration-200 text-sm">
                                WhatsApp Support
                            </a>
                        </div>
                    </div>

                    <!-- Newsletter Signup -->
                    <div class="mt-6">
                        <h5 class="text-sm font-semibold text-gray-300 mb-3">Newsletter</h5>
                        <form action="#" method="POST" class="flex">
                            <input type="email" name="email" placeholder="Your email" required
                                class="flex-1 px-3 py-2 bg-gray-800 text-white text-sm rounded-l-md border border-gray-700 focus:outline-none ">
                            <button type="submit"
                                class="bg-[#CBA660] px-4 py-2 rounded-r-md transition-colors duration-200">
                                <i class="fas fa-paper-plane text-sm"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Bottom Bar -->
        <div class="border-t border-gray-800 bg-gray-950">
            <div class="max-w-7xl mx-auto px-4 py-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <!-- Copyright -->
                    <div class="text-gray-400 text-sm mb-4 md:mb-0">
                        © {{ date('Y') }} ChriWBi3. All rights reserved. |
                        Powred by <a href="https://hamza-rhaidi.vercel.app/" class="text-[#CBA660]">Hamza Rhaidi</a>
                    </div>

                    <!-- Legal Links -->
                    <div class="flex flex-wrap justify-center md:justify-end space-x-6 text-sm">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">
                            Privacy Policy
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">
                            Terms of Service
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">
                            Cookie Policy
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>

</html>
