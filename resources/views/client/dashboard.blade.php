@extends('layouts.dashboard')

@section('title', 'Client Dashboard - Real Estate Platform')
@section('page-title', 'Welcome back, ' . auth()->user()->name)

@section('content')
<div class="space-y-8">
    
    
    <div class="relative overflow-hidden bg-gradient-to-r from-[#2F2B40] to-[#CBA660] rounded-2xl p-8 text-white shadow-2xl">
        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
        <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-12 -translate-x-12"></div>
        
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}!</h2>
                <p class="text-white/80 text-lg">Discover your dream property with ChriWBi3.</p>
            </div>
            <div class="hidden md:block">
                <i class="fas fa-home text-6xl text-[#CBA660]/30"></i>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <div class="group relative bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 overflow-hidden">
            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-[#CBA660]/20 to-transparent rounded-bl-3xl"></div>
            
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <div class="text-3xl font-bold text-[#2F2B40] mb-1">{{ $stats['favorites_count'] }}</div>
                    <div class="text-gray-600 font-medium">Favorite Properties</div>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-xl flex items-center justify-center">
                    <i class="fas fa-heart text-[#CBA660] text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Appointments Card -->
        <div class="group relative bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 overflow-hidden">
            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-[#CBA660]/20 to-transparent rounded-bl-3xl"></div>
            
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <div class="text-3xl font-bold text-[#2F2B40] mb-1">{{ $stats['appointments_count'] }}</div>
                    <div class="text-gray-600 font-medium">Total Appointments</div>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-xl flex items-center justify-center">
                    <i class="fas fa-calendar text-[#CBA660] text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Pending Appointments Card -->
        <div class="group relative bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 overflow-hidden">
            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-[#CBA660]/20 to-transparent rounded-bl-3xl"></div>
            
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <div class="text-3xl font-bold text-[#2F2B40] mb-1">{{ $stats['pending_appointments'] }}</div>
                    <div class="text-gray-600 font-medium">Pending Appointments</div>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clock text-[#CBA660] text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Confirmed Appointments Card -->
        <div class="group relative bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 overflow-hidden">
            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-[#CBA660]/20 to-transparent rounded-bl-3xl"></div>
            
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <div class="text-3xl font-bold text-[#2F2B40] mb-1">{{ $stats['confirmed_appointments'] }}</div>
                    <div class="text-gray-600 font-medium">Confirmed Appointments</div>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-[#CBA660] text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Favorites -->
        <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-[#2F2B40] mb-2">Recent Favorites</h3>
                        <p class="text-gray-600">Your saved properties</p>
                    </div>
                    <a href="{{ route('client.favorites.index') }}" 
                       class="bg-[#CBA660] text-white px-4 py-2 rounded-lg hover:bg-[#CBA660]/80 transition-all duration-300 text-sm font-medium">
                        View All
                    </a>
                </div>
            </div>
            
            <div class="p-8">
                @if($recentFavorites->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentFavorites->take(3) as $favorite)
                            <div class="group relative bg-gradient-to-r from-gray-50 to-gray-50/50 rounded-xl p-6 border border-gray-100 hover:shadow-lg transition-all duration-300 hover:border-[#CBA660]/30">
                                <div class="flex items-center space-x-4">
                                    <div class="relative">
                                        <img src="{{ $favorite->property->featured_image_url }}" 
                                             alt="{{ $favorite->property->title }}" 
                                             class="w-16 h-16 object-cover rounded-xl group-hover:scale-110 transition-transform duration-300">
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-bold text-[#2F2B40] text-lg mb-1">{{ Str::limit($favorite->property->title, 30) }}</h4>
                                        <p class="text-sm text-gray-600 mb-1">{{ $favorite->property->city->name }}</p>
                                        <p class="text-sm font-semibold text-[#CBA660]">{{ $favorite->property->formatted_price }}</p>
                                    </div>
                                    <a href="{{ route('properties.show', $favorite->property) }}" 
                                       class="bg-[#CBA660] text-white px-4 py-2 rounded-lg hover:bg-[#CBA660]/80 transition-all duration-300 text-sm font-medium transform hover:scale-105">
                                        View
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-16">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-heart text-4xl text-gray-400"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-[#2F2B40] mb-2">No favorite properties yet</h3>
                        <p class="text-gray-500 mb-6">Start exploring and save properties you love</p>
                        <a href="{{ route('home') }}" 
                           class="bg-[#CBA660] text-white px-6 py-3 rounded-lg hover:bg-[#CBA660]/80 transition-all duration-300 font-medium transform hover:scale-105">
                            Browse Properties
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Upcoming Appointments -->
        <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-[#2F2B40] mb-2">Upcoming Appointments</h3>
                        <p class="text-gray-600">Your scheduled property visits</p>
                    </div>
                    <a href="{{ route('client.appointments.index') }}" 
                       class="bg-[#CBA660] text-white px-4 py-2 rounded-lg hover:bg-[#CBA660]/80 transition-all duration-300 text-sm font-medium">
                        View All
                    </a>
                </div>
            </div>
            
            <div class="p-8">
                @if($upcomingAppointments->count() > 0)
                    <div class="space-y-4">
                        @foreach($upcomingAppointments->take(3) as $appointment)
                            <div class="group relative bg-gradient-to-r from-gray-50 to-gray-50/50 rounded-xl p-6 border border-gray-100 hover:shadow-lg transition-all duration-300 hover:border-[#CBA660]/30">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="relative">
                                            <div class="w-14 h-14 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                                <i class="fas fa-calendar text-[#CBA660] text-xl"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-[#2F2B40] text-lg">{{ Str::limit($appointment->property->title, 25) }}</h4>
                                            <p class="text-sm text-gray-600 mb-1">with {{ $appointment->owner->name }}</p>
                                            <p class="text-sm text-[#CBA660] font-medium">
                                                <i class="fas fa-clock mr-1"></i>
                                                {{ $appointment->appointment_date->format('M d, Y - H:i') }}
                                            </p>
                                        </div>
                                    </div>
                                    <span class="px-4 py-2 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                                        Confirmed
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-16">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-calendar text-4xl text-gray-400"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-[#2F2B40] mb-2">No upcoming appointments</h3>
                        <p class="text-gray-500">Your scheduled appointments will appear here</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection