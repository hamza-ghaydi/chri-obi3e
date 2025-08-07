@extends('layouts.dashboard')

@section('title', 'My Appointments - Client Dashboard')
@section('page-title', 'My Appointments')

@section('content')
<div class="space-y-8">
 
    <div class="relative overflow-hidden bg-gradient-to-r from-[#2F2B40] to-[#CBA660] rounded-2xl p-8 text-white shadow-2xl">
        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
        <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-12 -translate-x-12"></div>
        
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold mb-2">My Appointments</h2>
                <p class="text-white/80 text-lg">Manage your property viewing appointments</p>
            </div>
           
        </div>
    </div>

    {{-- All Appointments --}}
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold text-[#2F2B40] mb-2">My Appointments</h3>
                    <p class="text-gray-600">Track and manage your property viewings</p>
                </div>
                <div class="flex space-x-3">
                    <select class="bg-white border border-gray-300 rounded-xl px-6 py-3 text-sm font-medium text-gray-700 hover:border-[#CBA660] focus:border-[#CBA660] focus:ring-2 focus:ring-[#CBA660]/20 transition-all duration-300">
                        <option>All Status</option>
                        <option>Confirmed</option>
                        <option>Pending</option>
                        <option>Cancelled</option>
                    </select>
                </div>
            </div>
        </div>
        
        @if($appointments->count() > 0)
            
            <div class="p-8 space-y-6">
                @foreach($appointments as $appointment)
                    <div class="group bg-white border border-gray-200 rounded-2xl p-6 ">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-4 mb-4">
                                    <h4 class="text-xl font-bold text-[#2F2B40] group-hover:text-[#CBA660] transition-colors duration-300">
                                        {{ $appointment->property->title }}
                                    </h4>
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold backdrop-blur-sm
                                        @if($appointment->status === 'confirmed')  bg-green-200
                                        @elseif($appointment->status === 'pending') bg-yellow-200
                                        @elseif($appointment->status === 'rejected') bg-red-200
                                        @else bg-gray-500/90 text-white @endif">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <div class="flex items-center p-3 bg-gradient-to-r from-[#CBA660]/5 to-[#CBA660]/10 rounded-xl">
                                        <div class="w-10 h-10 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-xl flex items-center justify-center mr-3">
                                            <i class="fas fa-calendar text-[#CBA660]"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 font-medium">Date</p>
                                            <p class="text-sm font-semibold text-[#2F2B40]">{{ $appointment->appointment_date->format('M j, Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center p-3 bg-gradient-to-r from-[#2F2B40]/5 to-[#2F2B40]/10 rounded-xl">
                                        <div class="w-10 h-10 bg-gradient-to-br from-[#2F2B40]/20 to-[#2F2B40]/40 rounded-xl flex items-center justify-center mr-3">
                                            <i class="fas fa-clock text-[#2F2B40]"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 font-medium">Time</p>
                                            <p class="text-sm font-semibold text-[#2F2B40]">{{ $appointment->appointment_date->format('g:i A') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center p-3 bg-gradient-to-r from-gray-100/50 to-gray-200/50 rounded-xl">
                                        <div class="w-10 h-10 bg-gradient-to-br from-gray-300/50 to-gray-400/50 rounded-xl flex items-center justify-center mr-3">
                                            <i class="fas fa-user text-gray-600"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 font-medium">Owner</p>
                                            <p class="text-sm font-semibold text-[#2F2B40]">{{ $appointment->owner->name }}</p>
                                        </div>
                                    </div>
                                </div>

                                
                            </div>

                            <div class="flex flex-col space-y-3 ml-6">
                                <a href="{{ route('properties.show', $appointment->property) }}"
                                   class="bg-white border border-[#CBA660] text-[#CBA660] px-4 py-2 rounded-xl hover:bg-[#CBA660]/5 transition-all duration-300 text-sm font-medium text-center whitespace-nowrap">
                                    <i class="fas fa-eye mr-2"></i>View Property
                                </a>

                                @if($appointment->status === 'pending')
                                    <button class="bg-white border border-red-300 text-red-600 px-4 py-2 rounded-xl hover:bg-red-50 hover:border-red-400 transition-all duration-300 text-sm font-medium whitespace-nowrap">
                                        <i class="fas fa-times mr-2"></i>Cancel
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="p-8">
                <div class="text-center py-16">
                    <div class="max-w-md mx-auto">
                        <div class="w-24 h-24 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-calendar-check text-4xl text-[#CBA660]"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-[#2F2B40] mb-4">No Appointments Scheduled</h3>
                        <p class="text-gray-600 mb-8">Start browsing properties and request appointments to view them in person.</p>

                        <div class="space-y-6">
                            <a href="{{ route('home') }}" 
                               class="inline-flex items-center bg-gradient-to-r from-[#CBA660] to-[#CBA660]/80 text-white font-semibold px-8 py-4 rounded-xl hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                <i class="fas fa-search mr-2"></i>Browse Properties
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    
</div>
@endsection