@extends('layouts.dashboard')

@section('title', 'Admin Dashboard - ChriWBi3 Real Estate Platform')
@section('page-title', 'Administrator Dashboard')

@section('breadcrumb')
    <i class="fas fa-home text-[#CBA660] mr-1"></i>
    <span class="text-gray-400">Dashboard</span>
    <i class="fas fa-chevron-right text-gray-300 mx-2"></i>
    <span class="text-[#CBA660] font-medium">Admin Panel</span>
@endsection

@section('content')
<div class="space-y-8">
    <!-- Welcome Banner -->
    <div class="relative overflow-hidden bg-gradient-to-r from-[#2F2B40] to-[#CBA660] rounded-2xl p-8 text-white shadow-2xl">
        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
        <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-12 -translate-x-12"></div>
        
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}!</h2>
                <p class="text-white/80 text-lg">Here's what's happening with ChriWBi3 today.</p>
            </div>
            <div class="hidden md:block">
                <i class="fas fa-crown text-6xl text-[#CBA660]/30"></i>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Users Card -->
        <div class="group relative bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100  overflow-hidden">
            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-[#CBA660]/20 to-transparent rounded-bl-3xl"></div>
            
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <div class="text-3xl font-bold text-[#2F2B40] mb-1">
                        {{ \App\Models\User::count() ?? 0 }}
                    </div>
                    <div class="text-gray-600 font-medium">Total Users</div>
                    
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-xl flex items-center justify-center">
                    <i class="fas fa-users text-[#CBA660] text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Properties Card -->
        <div class="group relative bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100  overflow-hidden">
            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-[#CBA660]/20 to-transparent rounded-bl-3xl"></div>
            
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <div class="text-3xl font-bold text-[#2F2B40] mb-1">
                        {{ \App\Models\Property::count() ?? 0 }}
                    </div>
                    <div class="text-gray-600 font-medium">Total Properties</div>
                    
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-xl flex items-center justify-center">
                    <i class="fas fa-building text-[#CBA660] text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Pending Approvals Card -->
        <div class="group relative bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 0 overflow-hidden">
            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-[#CBA660]/20 to-transparent rounded-bl-3xl"></div>
            
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <div class="text-3xl font-bold text-[#2F2B40] mb-1">
                        {{ \App\Models\Property::where('status', 'pending')->count() ?? 0 }}
                    </div>
                    <div class="text-gray-600 font-medium">Pending Approvals</div>
                    
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-xl flex items-center justify-center">
                    <i class="fas fa-hourglass-half text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Revenue Card -->
        <div class="group relative bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 overflow-hidden">
            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-[#CBA660]/20 to-transparent rounded-bl-3xl"></div>
            
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <div class="text-3xl font-bold text-[#2F2B40] mb-1">
                        25.4K
                    </div>
                    <div class="text-gray-600 font-medium">Total Revenue (MAD)</div>
                    
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-xl flex items-center justify-center">
                    <i class="fas fa-chart-line text-[#CBA660] text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold text-[#2F2B40] mb-2">Quick Actions</h3>
                    <p class="text-gray-600">Manage your platform efficiently with these shortcuts</p>
                </div>
                <i class="fas fa-bolt text-3xl text-[#CBA660]"></i>
            </div>
        </div>
        
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <a href="{{ route('admin.users.index') }}" 
                   class="group relative bg-gradient-to-br from-[#CBA660] to-[#CBA660]/80 text-white p-6 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 overflow-hidden">
                    <div class="absolute top-0 right-0 w-16 h-16 bg-white/10 rounded-full -translate-y-8 translate-x-8"></div>
                    <div class="relative z-10 text-center">
                        <i class="fas fa-users text-3xl mb-4 block"></i>
                        <span class="font-semibold text-lg">Manage Users</span>
                        <div class="text-sm opacity-80 mt-2">{{ \App\Models\User::count() }} users</div>
                    </div>
                </a>
                
                <a href="{{ route('admin.properties.index') }}" 
                   class="group relative bg-gradient-to-br from-[#CBA660] to-[#CBA660]/80 text-white p-6 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 overflow-hidden">
                    <div class="absolute top-0 right-0 w-16 h-16 bg-white/10 rounded-full -translate-y-8 translate-x-8"></div>
                    <div class="relative z-10 text-center">
                        <i class="fas fa-building text-3xl mb-4 block"></i>
                        <span class="font-semibold text-lg">Manage Properties</span>
                        <div class="text-sm opacity-80 mt-2">{{ \App\Models\Property::count() }} properties</div>
                    </div>
                </a>
                
                {{-- <a href="{{ route('admin.payments.index') }}" 
                   class="group relative bg-gradient-to-br from-[#CBA660] to-[#CBA660]/80 text-white p-6 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 overflow-hidden">
                    <div class="absolute top-0 right-0 w-16 h-16 bg-white/10 rounded-full -translate-y-8 translate-x-8"></div>
                    <div class="relative z-10 text-center">
                        <i class="fas fa-credit-card text-3xl mb-4 block"></i>
                        <span class="font-semibold text-lg">View Payments</span>
                        <div class="text-sm opacity-80 mt-2">Financial overview</div>
                    </div>
                </a> --}}
                
                <a href="{{ route('admin.categories.index') }}" 
                   class="group relative bg-gradient-to-br from-[#CBA660] to-[#CBA660]/80 text-white p-6 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 overflow-hidden">
                    <div class="absolute top-0 right-0 w-16 h-16 bg-white/10 rounded-full -translate-y-8 translate-x-8"></div>
                    <div class="relative z-10 text-center">
                        <i class="fas fa-tags text-3xl mb-4 block"></i>
                        <span class="font-semibold text-lg">Manage Categories</span>
                        <div class="text-sm opacity-80 mt-2">Property types</div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    

    <!-- Administrator Control Panel Info -->
    <div class="bg-gradient-to-r from-[#2F2B40] to-[#CBA660] rounded-2xl p-8 text-white shadow-2xl">
        <div class="text-center">
            <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-shield-alt text-4xl text-white"></i>
            </div>
            <h3 class="text-3xl font-bold mb-4">Administrator Control Panel</h3>
            <p class="text-white/80 text-lg mb-6 max-w-2xl mx-auto">
                Manage all aspects of the ChriWBi3 real estate platform from this central dashboard. 
                Monitor performance, oversee users, and ensure smooth operations.
            </p>
        </div>
    </div>
</div>
@endsection
