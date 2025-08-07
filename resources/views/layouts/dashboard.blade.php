<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard - Real Estate Platform')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="font-sans bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-[#2F2B40] text-white flex-shrink-0 shadow-xl">
            <!-- Logo -->
            <div class="p-6 border-b border-[#CBA660]/20">
                <a href="{{ route('home') }}"
                    class="flex items-center justify-center">
                    <img src="{{ asset('logo_chriwbi3.png') }}" alt="Chriwbi3 Logo" class="w-16">
                </a>
            </div>

            <!-- User Info -->
            <div class="p-6 border-b border-[#CBA660]/20 bg-gradient-to-r from-black/20 to-transparent">
                <div class="flex items-center">
                    <div class="text-center w-full">
                        <div class="font-semibold text-xl text-white mb-1">{{ auth()->user()->name }}</div>
                        <div
                            class="text-sm text-[#CBA660] capitalize font-medium bg-[#CBA660]/10 px-3 py-1 rounded-full inline-block">
                            {{ auth()->user()->role }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-6">
                <ul class="flex flex-col justify-between">
                    <div class="space-y-2 mb-16">
                        @if (auth()->user()->isAdmin())
                            <!-- Admin Navigation -->
                            <li>
                                <a href="{{ route('admin.dashboard') }}"
                                    class="flex items-center px-4 py-3 text-gray-300 hover:bg-[#CBA660]/10 hover:text-[#CBA660] rounded-lg transition-all duration-200 font-medium group {{ request()->routeIs('admin.dashboard') ? 'bg-[#CBA660]/20 text-[#CBA660] border-r-4 border-[#CBA660]' : '' }}">
                                    <i
                                        class="fas fa-tachometer-alt mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                    <span
                                        class="group-hover:translate-x-1 transition-transform duration-200">Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.users.index') }}"
                                    class="flex items-center px-4 py-3 text-gray-300 hover:bg-[#CBA660]/10 hover:text-[#CBA660] rounded-lg transition-all duration-200 font-medium group {{ request()->routeIs('admin.users.*') ? 'bg-[#CBA660]/20 text-[#CBA660] border-r-4 border-[#CBA660]' : '' }}">
                                    <i
                                        class="fas fa-users mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                    <span class="group-hover:translate-x-1 transition-transform duration-200">Manage
                                        Users</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.properties.index') }}"
                                    class="flex items-center px-4 py-3 text-gray-300 hover:bg-[#CBA660]/10 hover:text-[#CBA660] rounded-lg transition-all duration-200 font-medium group {{ request()->routeIs('admin.properties.*') ? 'bg-[#CBA660]/20 text-[#CBA660] border-r-4 border-[#CBA660]' : '' }}">
                                    <i
                                        class="fas fa-building mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                    <span class="group-hover:translate-x-1 transition-transform duration-200">Manage
                                        Properties</span>
                                </a>
                            </li>
                            {{-- <li>
                            <a href="{{ route('admin.payments.index') }}" 
                               class="flex items-center px-4 py-3 text-gray-300 hover:bg-[#CBA660]/10 hover:text-[#CBA660] rounded-lg transition-all duration-200 font-medium group {{ request()->routeIs('admin.payments.*') ? 'bg-[#CBA660]/20 text-[#CBA660] border-r-4 border-[#CBA660]' : '' }}">
                                <i class="fas fa-credit-card mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                <span class="group-hover:translate-x-1 transition-transform duration-200">Payments</span>
                            </a>
                        </li> --}}
                            <li>
                                <a href="{{ route('admin.categories.index') }}"
                                    class="flex items-center px-4 py-3 text-gray-300 hover:bg-[#CBA660]/10 hover:text-[#CBA660] rounded-lg transition-all duration-200 font-medium group {{ request()->routeIs('admin.categories.*') ? 'bg-[#CBA660]/20 text-[#CBA660] border-r-4 border-[#CBA660]' : '' }}">
                                    <i
                                        class="fas fa-tags mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                    <span
                                        class="group-hover:translate-x-1 transition-transform duration-200">Categories</span>
                                </a>
                            </li>
                        @elseif(auth()->user()->isOwner())
                            <!-- Owner Navigation -->
                            <li>
                                <a href="{{ route('owner.dashboard') }}"
                                    class="flex items-center px-4 py-3 text-gray-300 hover:bg-[#CBA660]/10 hover:text-[#CBA660] rounded-lg transition-all duration-200 font-medium group {{ request()->routeIs('owner.dashboard') ? 'bg-[#CBA660]/20 text-[#CBA660] border-r-4 border-[#CBA660]' : '' }}">
                                    <i
                                        class="fas fa-tachometer-alt mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                    <span
                                        class="group-hover:translate-x-1 transition-transform duration-200">Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('owner.properties.index') }}"
                                    class="flex items-center px-4 py-3 text-gray-300 hover:bg-[#CBA660]/10 hover:text-[#CBA660] rounded-lg transition-all duration-200 font-medium group {{ request()->routeIs('owner.properties.*') ? 'bg-[#CBA660]/20 text-[#CBA660] border-r-4 border-[#CBA660]' : '' }}">
                                    <i
                                        class="fas fa-building mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                    <span class="group-hover:translate-x-1 transition-transform duration-200">My
                                        Properties</span>
                                </a>
                            </li>
                            {{-- <li>
                                <a href="{{ route('owner.properties.create') }}"
                                    class="flex items-center px-4 py-3 text-gray-300 hover:bg-[#CBA660]/10 hover:text-[#CBA660] rounded-lg transition-all duration-200 font-medium group {{ request()->routeIs('owner.properties.create') ? 'bg-[#CBA660]/20 text-[#CBA660] border-r-4 border-[#CBA660]' : '' }}">
                                    <i
                                        class="fas fa-plus mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                    <span class="group-hover:translate-x-1 transition-transform duration-200">Add
                                        Property</span>
                                </a>
                            </li> --}}
                            <li>
                                <a href="{{ route('owner.appointments.index') }}"
                                    class="flex items-center px-4 py-3 text-gray-300 hover:bg-[#CBA660]/10 hover:text-[#CBA660] rounded-lg transition-all duration-200 font-medium group {{ request()->routeIs('owner.appointments.*') ? 'bg-[#CBA660]/20 text-[#CBA660] border-r-4 border-[#CBA660]' : '' }}">
                                    <i
                                        class="fas fa-calendar mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                    <span
                                        class="group-hover:translate-x-1 transition-transform duration-200">Appointments</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('owner.payments.index') }}"
                                    class="flex items-center px-4 py-3 text-gray-300 hover:bg-[#CBA660]/10 hover:text-[#CBA660] rounded-lg transition-all duration-200 font-medium group {{ request()->routeIs('owner.payments.*') ? 'bg-[#CBA660]/20 text-[#CBA660] border-r-4 border-[#CBA660]' : '' }}">
                                    <i
                                        class="fas fa-credit-card mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                    <span
                                        class="group-hover:translate-x-1 transition-transform duration-200">Payments</span>
                                </a>
                            </li>
                        @elseif(auth()->user()->isClient())
                            <!-- Client Navigation -->
                            <li>
                                <a href="{{ route('client.dashboard') }}"
                                    class="flex items-center px-4 py-3 text-gray-300 hover:bg-[#CBA660]/10 hover:text-[#CBA660] rounded-lg transition-all duration-200 font-medium group {{ request()->routeIs('client.dashboard') ? 'bg-[#CBA660]/20 text-[#CBA660] border-r-4 border-[#CBA660]' : '' }}">
                                    <i
                                        class="fas fa-tachometer-alt mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                    <span
                                        class="group-hover:translate-x-1 transition-transform duration-200">Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('client.favorites.index') }}"
                                    class="flex items-center px-4 py-3 text-gray-300 hover:bg-[#CBA660]/10 hover:text-[#CBA660] rounded-lg transition-all duration-200 font-medium group {{ request()->routeIs('client.favorites.*') ? 'bg-[#CBA660]/20 text-[#CBA660] border-r-4 border-[#CBA660]' : '' }}">
                                    <i
                                        class="fas fa-heart mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                    <span class="group-hover:translate-x-1 transition-transform duration-200">My
                                        Favorites</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('client.appointments.index') }}"
                                    class="flex items-center px-4 py-3 text-gray-300 hover:bg-[#CBA660]/10 hover:text-[#CBA660] rounded-lg transition-all duration-200 font-medium group {{ request()->routeIs('client.appointments.*') ? 'bg-[#CBA660]/20 text-[#CBA660] border-r-4 border-[#CBA660]' : '' }}">
                                    <i
                                        class="fas fa-calendar mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                    <span class="group-hover:translate-x-1 transition-transform duration-200">My
                                        Appointments</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('client.properties.index') }}"
                                    class="flex items-center px-4 py-3 text-gray-300 hover:bg-[#CBA660]/10 hover:text-[#CBA660] rounded-lg transition-all duration-200 font-medium group {{ request()->routeIs('client.properties.*') ? 'bg-[#CBA660]/20 text-[#CBA660] border-r-4 border-[#CBA660]' : '' }}">
                                    <i
                                        class="fas fa-handshake mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                    <span class="group-hover:translate-x-1 transition-transform duration-200">My
                                        Properties</span>
                                </a>
                            </li>
                        @endif
                    </div>

                    <!-- Common Links -->
                    <div class="space-y-2">
                        <li class="pt-4 border-t border-[#CBA660]/20 mt-4">
                            <a href="{{ route('home') }}"
                                class="flex items-center px-4 py-3 text-gray-300 hover:bg-[#CBA660]/10 hover:text-[#CBA660] rounded-lg transition-all duration-200 font-medium group">
                                <i class="fas fa-home mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                <span class="group-hover:translate-x-1 transition-transform duration-200">Home
                                    Page</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center px-4 py-3 text-gray-300 hover:bg-[#CBA660]/10 hover:text-[#CBA660] rounded-lg transition-all duration-200 font-medium group {{ request()->routeIs('profile.*') ? 'bg-[#CBA660]/20 text-[#CBA660] border-r-4 border-[#CBA660]' : '' }}">
                                <i class="fas fa-user mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                <span class="group-hover:translate-x-1 transition-transform duration-200">Profile
                                    Settings</span>
                            </a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="flex items-center px-4 py-3 text-gray-300 hover:bg-red-500/10 hover:text-red-400 rounded-lg transition-all duration-200 font-medium group w-full text-left">
                                    <i
                                        class="fas fa-sign-out-alt mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                    <span
                                        class="group-hover:translate-x-1 transition-transform duration-200">Logout</span>
                                </button>
                            </form>
                        </li>
                    </div>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden bg-gray-50">
            <!-- Top Header -->
            <header class="bg-[#2F2B40] shadow-sm border-b border-[#CBA660] px-6 py-6 ">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-[#CBA660]">@yield('page-title', 'Dashboard')</h1>
                    </div>

                    <div class="flex items-center space-x-4">


                    </div>
                </div>
            </header>

            <!-- Flash Messages -->
            @if (session('success'))
                <div class="bg-green-50 border-l-4 border-green-400 text-green-800 px-6 py-4 mx-6 mt-4 rounded-r-lg shadow-sm"
                    role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-3 text-green-500"></i>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-50 border-l-4 border-red-400 text-red-800 px-6 py-4 mx-6 mt-4 rounded-r-lg shadow-sm"
                    role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-3 text-red-500"></i>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
