@extends('layouts.main')

@section('title', 'Appointment Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        
        
        <div class="mb-8">
            <div class="relative overflow-hidden bg-gradient-to-r from-[#2F2B40] to-[#CBA660] rounded-2xl p-8 text-white shadow-2xl">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-12 -translate-x-12"></div>
                
                <div class="relative z-10">
                    
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-4xl font-bold mb-3">Appointment Details</h1>
                            <p class="text-white/80 text-lg">Manage your property visit appointment</p>
                        </div>
                        <div class="hidden md:block">
                            <i class="fas fa-calendar-check text-6xl text-[#CBA660]/30"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="bg-gradient-to-r from-green-50 to-green-100 border border-green-200 rounded-2xl p-6 mb-8 shadow-lg">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-check-circle text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-green-800 text-lg">Success!</h3>
                        <p class="text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-gradient-to-r from-red-50 to-red-100 border border-red-200 rounded-2xl p-6 mb-8 shadow-lg">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-red-500 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-exclamation-circle text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-red-800 text-lg">Error!</h3>
                        <p class="text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Appointment Details --}}

            <div class="lg:col-span-2 space-y-8">
                
                <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-2xl font-bold text-[#2F2B40] mb-2">Appointment Status</h2>
                                <p class="text-gray-600">Current status and timeline information</p>
                            </div>
                            <span class="px-6 py-3 rounded-2xl text-sm font-bold shadow-lg transform hover:scale-105 transition-all duration-300
                                {{ $appointment->status === 'confirmed' ? 'bg-green-300 text-black' : '' }}
                                {{ $appointment->status === 'pending' ? 'bg-yellow-200 text-black' : '' }}
                                {{ $appointment->status === 'rejected' ? 'bg-red-300 text-black' : '' }}">
                                <i class="fas fa-{{ $appointment->status === 'confirmed' ? 'check-circle' : ($appointment->status === 'pending' ? 'clock' : 'times-circle') }} mr-2"></i>
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="p-8">
                        <div class="grid grid-cols-1 md:grid-cols-1 gap-8">
                            <div class="bg-gradient-to-br from-[#2F2B40]/5 to-[#CBA660]/10 p-6 rounded-2xl">
                                <div class="flex items-center mb-3">
                                    <div class="w-10 h-10 bg-[#CBA660] rounded-xl flex items-center justify-center mr-3">
                                        <i class="fas fa-calendar text-white"></i>
                                    </div>
                                    <label class="text-sm font-bold text-[#2F2B40]">Appointment Date & Time</label>
                                </div>
                                <p class="text-xl font-bold text-[#2F2B40]">
                                    {{ $appointment->appointment_date->format('F j, Y') }}
                                </p>
                                <p class="text-[#CBA660] font-bold text-lg">
                                    {{ $appointment->appointment_date->format('g:i A') }}
                                </p>
                            </div>

                            

                            {{-- @if($appointment->confirmed_at || $appointment->rejected_at)
                                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-2xl">
                                    <div class="flex items-center mb-3">
                                        <div class="w-10 h-10 bg-blue-500 rounded-xl flex items-center justify-center mr-3">
                                            <i class="fas fa-reply text-white"></i>
                                        </div>
                                        <label class="text-sm font-bold text-[#2F2B40]">Owner Response</label>
                                    </div>
                                    <p class="text-xl font-bold text-[#2F2B40]">
                                        {{ ($appointment->confirmed_at ?: $appointment->rejected_at)->format('F j, Y') }}
                                    </p>
                                    <p class="text-gray-600 font-medium">
                                        {{ ($appointment->confirmed_at ?: $appointment->rejected_at)->diffForHumans() }}
                                    </p>
                                </div>
                            @endif --}}
                        </div>

                        @if($appointment->client_message)
                            <div class="mt-8 pt-8 border-t border-gray-200">
                                <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 p-6 rounded-2xl">
                                    <div class="flex items-center mb-4">
                                        <div class="w-10 h-10 bg-[#CBA660] rounded-xl flex items-center justify-center mr-3">
                                            <i class="fas fa-comment text-white"></i>
                                        </div>
                                        <label class="text-sm font-bold text-[#2F2B40]">Your Notes</label>
                                    </div>
                                    <p class="text-[#2F2B40] leading-relaxed">{{ $appointment->client_message }}</p>
                                </div>
                            </div>
                        @endif

                        @if($appointment->owner_response)
                            <div class="mt-8 pt-8 border-t ">
                                <div class=" p-6 rounded-2xl ">
                                    <div class="flex items-center mb-4">
                                        
                                        <label class="text-sm font-bold text-[#2F2B40]">Owner's Response</label>
                                    </div>
                                    <p class="text-[#2F2B40] leading-relaxed">{{ $appointment->owner_response }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Owner Actions -->
                @if(Auth::id() === $appointment->owner_id && $appointment->status === 'pending')
                    <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-[#CBA660]/10 to-[#CBA660]/20 px-8 py-6 border-b border-gray-100">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-[#CBA660] rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-user-cog text-white text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-[#2F2B40]">Respond to Appointment Request</h3>
                                    <p class="text-gray-600">Confirm or reject this appointment request</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-8">
                            <form action="{{ route('appointments.update-status', $appointment) }}" method="POST" class="space-y-6">
                                @csrf
                                @method('PATCH')
                                
                                <div>
                                    <label class="block text-sm font-bold text-[#2F2B40] mb-3">Response Notes (Optional)</label>
                                    <textarea name="owner_response" rows="4"
                                              class="w-full px-4 py-4 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#CBA660] focus:border-transparent transition-all duration-300 resize-none"
                                              placeholder="Add any additional information or instructions...">{{ old('owner_response') }}</textarea>
                                </div>
                                
                                <div class="flex space-x-4">
                                    <button type="submit" name="status" value="confirmed" 
                                            class="flex-1 bg-gradient-to-r from-green-500 to-green-600 text-white py-4 px-6 rounded-xl hover:shadow-lg transition-all duration-300 font-bold text-lg transform hover:scale-105">
                                        <i class="fas fa-check mr-3"></i>Confirm Appointment
                                    </button>
                                    
                                    <button type="submit" name="status" value="rejected" 
                                            class="flex-1 bg-gradient-to-r from-red-500 to-red-600 text-white py-4 px-6 rounded-xl hover:shadow-lg transition-all duration-300 font-bold text-lg transform hover:scale-105">
                                        <i class="fas fa-times mr-3"></i>Reject Appointment
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif

                <!-- Next Steps for Client -->
                @if(Auth::id() === $appointment->client_id)
                    <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-[#CBA660] rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-route text-white text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-[#2F2B40]">What's Next?</h3>
                                    <p class="text-gray-600">Follow these steps to complete your process</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-8">
                            @if($appointment->status === 'pending')
                                <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 p-6 rounded-2xl border border-yellow-200">
                                    <div class="flex items-start">
                                        <div class="w-12 h-12 bg-yellow-500 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                            <i class="fas fa-clock text-white text-xl"></i>
                                        </div>
                                        <div>
                                            <p class="font-bold text-yellow-800 text-lg mb-2">Waiting for Owner Response</p>
                                            <p class="text-yellow-700 leading-relaxed">
                                                Your appointment request has been sent to the property owner. 
                                                You'll receive an email notification once they respond.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @elseif($appointment->status === 'confirmed')
                                <div class="bg-gradient-to-r from-green-50 to-green-100 p-6 rounded-2xl border border-green-200 mb-6">
                                    <div class="flex items-start">
                                        <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                            <i class="fas fa-check-circle text-white text-xl"></i>
                                        </div>
                                        <div>
                                            <p class="font-bold text-green-800 text-lg mb-2">Appointment Confirmed!</p>
                                            <p class="text-green-700 leading-relaxed">
                                                Your visit has been confirmed. Please arrive on time and bring a valid ID.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Payment Button -->
                                <div class="text-center bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 p-8 rounded-2xl">
                                    <a href="{{ route('payments.create', $appointment->property) }}" 
                                       class="inline-block bg-gradient-to-r from-[#CBA660] to-[#CBA660]/80 text-white py-4 px-8 rounded-xl hover:shadow-lg transition-all duration-300 font-bold text-lg transform hover:scale-105">
                                        Continue with Owner
                                    </a>
                                    <p class="text-gray-600 mt-4 font-medium">Complete your property acquisition process</p>
                                </div>
                            @elseif($appointment->status === 'rejected')
                                <div class="bg-gradient-to-r from-red-50 to-red-100 p-6 rounded-2xl border border-red-200">
                                    <div class="flex items-start">
                                        <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                            <i class="fas fa-times-circle text-white text-xl"></i>
                                        </div>
                                        <div>
                                            <p class="font-bold text-red-800 text-lg mb-3">Appointment Not Available</p>
                                            <p class="text-red-700 leading-relaxed mb-4">
                                                Unfortunately, this appointment time is not available. 
                                                You can schedule a new appointment with different date/time.
                                            </p>
                                            <a href="{{ route('appointments.create', $appointment->property) }}" 
                                               class="inline-block bg-gradient-to-r from-[#CBA660] to-[#CBA660]/80 text-white py-3 px-6 rounded-xl hover:shadow-lg transition-all duration-300 font-bold transform hover:scale-105">
                                                <i class="fas fa-calendar-plus mr-2"></i>Schedule New Appointment
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Property Card -->
                <div class="group relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-500">
                    <div class="relative">
                        <img src="{{ $appointment->property->featured_image_url }}" alt="{{ $appointment->property->title }}" class="w-full h-56 object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-[#2F2B40] mb-4">{{ $appointment->property->title }}</h3>
                        
                        <div class="space-y-3 mb-6">
                            <div class="flex items-center bg-gray-50 p-3 rounded-xl">
                                <div class="w-8 h-8 bg-[#CBA660]/20 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-map-marker-alt text-[#CBA660]"></i>
                                </div>
                                <span class="text-gray-700 font-medium">{{ $appointment->property->address }}, {{ $appointment->property->city->name }}</span>
                            </div>
                            
                            <div class="flex items-center bg-gradient-to-r from-[#CBA660]/10 to-[#CBA660]/20 p-3 rounded-xl">
                                <div class="w-8 h-8 bg-[#CBA660] rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-dollar-sign text-white"></i>
                                </div>
                                <span class="text-[#CBA660] font-bold text-lg">{{ $appointment->property->formatted_price }}</span>
                            </div>
                        </div>
                        
                        <a href="{{ route('properties.show', $appointment->property) }}" 
                           class="block text-center bg-gradient-to-r from-[#CBA660] to-[#CBA660]/80 text-white py-3 rounded-xl hover:shadow-lg transition-all duration-300 font-bold transform hover:scale-105">
                            <i class="fas fa-eye mr-2"></i>View Property Details
                        </a>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-6 py-4 border-b border-gray-100">
                        <h3 class="text-xl font-bold text-[#2F2B40]">
                            @if(Auth::id() === $appointment->client_id)
                                Property Owner
                            @else
                                Client Information
                            @endif
                        </h3>
                    </div>
                    
                    <div class="p-6">
                        @if(Auth::id() === $appointment->client_id)
                            <!-- Show owner info to client -->
                            <div class="flex items-center space-x-4 mb-6">
                                
                                <div>
                                    <div class="text-xl font-bold text-[#2F2B40]">{{ $appointment->property->owner->name }}</div>
                                    <div class="text-sm text-gray-600 font-medium">Property Owner</div>
                                </div>
                            </div>
                            
                            <div class="space-y-3">
                                <div class="flex items-center bg-gray-50 p-3 rounded-xl">
                                    <div class="w-8 h-8 bg-[#CBA660]/20 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-envelope text-[#CBA660]"></i>
                                    </div>
                                    <span class="text-gray-700 font-medium">{{ $appointment->property->owner->email }}</span>
                                </div>
                                
                                @if($appointment->property->owner->phone)
                                    <div class="flex items-center bg-gray-50 p-3 rounded-xl">
                                        <div class="w-8 h-8 bg-[#CBA660]/20 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-phone text-[#CBA660]"></i>
                                        </div>
                                        <span class="text-gray-700 font-medium">{{ $appointment->property->owner->phone }}</span>
                                    </div>
                                @endif
                            </div>
                        @else
                            <!-- Show client info to owner -->
                            <div class="flex items-center space-x-4 mb-6">
                                <img src="{{ $appointment->client->profile_picture_url }}" alt="{{ $appointment->client->name }}" 
                                     class="w-16 h-16 rounded-full shadow-lg">
                                <div>
                                    <div class="text-xl font-bold text-[#2F2B40]">{{ $appointment->client->name }}</div>
                                    <div class="text-sm text-gray-600 font-medium">Client</div>
                                </div>
                            </div>
                            
                            <div class="space-y-3">
                                <div class="flex items-center bg-gray-50 p-3 rounded-xl">
                                    <div class="w-8 h-8 bg-[#CBA660]/20 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-envelope text-[#CBA660]"></i>
                                    </div>
                                    <span class="text-gray-700 font-medium">{{ $appointment->client->email }}</span>
                                </div>
                                
                                @if($appointment->client->phone)
                                    <div class="flex items-center bg-gray-50 p-3 rounded-xl">
                                        <div class="w-8 h-8 bg-[#CBA660]/20 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-phone text-[#CBA660]"></i>
                                        </div>
                                        <span class="text-gray-700 font-medium">{{ $appointment->client->phone }}</span>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Process Steps --}}
                <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-[#CBA660]/20 px-6 py-4">
                        <h3 class="text-xl font-bold text-[#CBA660] flex items-center">
                            <i class="fas fa-route mr-3"></i>Next Steps
                        </h3>
                    </div>
                    
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-center p-4">
                                
                                <span class="text-[#CBA660] font-bold">✓ Step 1: Contact Owner - Completed</span>
                            </div>
                            <div class="flex items-center  p-4">
                                
                                <span class="text-[#2F2B40] font-bold">→ Step 2: Schedule Visit - In Progress</span>
                            </div>
                            <div class="flex items-center p-4">
                                
                                <span class="text-[#2F2B40] font-bold">→ Step 3: Continue with Owner</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection