@extends('layouts.app')

@section('title', 'Appointment Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <nav class="text-sm text-gray-600 mb-4">
                <a href="{{ route('home') }}" class="hover:text-brand-dark">Home</a>
                <span class="mx-2">/</span>
                <a href="{{ route('properties.show', $appointment->property) }}" class="hover:text-brand-dark">{{ $appointment->property->title }}</a>
                <span class="mx-2">/</span>
                <span>Appointment Details</span>
            </nav>
            
            <h1 class="text-3xl font-bold text-brand-dark mb-2">Appointment Details</h1>
            <p class="text-gray-600">Manage your property visit appointment</p>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Appointment Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Status Card -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-semibold text-brand-dark">Appointment Status</h2>
                        <span class="px-4 py-2 rounded-full text-sm font-semibold
                            {{ $appointment->status === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $appointment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $appointment->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ ucfirst($appointment->status) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-sm font-medium text-gray-600">Appointment Date & Time</label>
                            <p class="text-lg font-semibold text-brand-dark">
                                {{ $appointment->appointment_date->format('F j, Y') }}
                            </p>
                            <p class="text-brand-dark">
                                {{ $appointment->appointment_date->format('g:i A') }}
                            </p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-600">Requested On</label>
                            <p class="text-lg font-semibold text-brand-dark">
                                {{ $appointment->created_at->format('F j, Y') }}
                            </p>
                            <p class="text-gray-600">
                                {{ $appointment->created_at->diffForHumans() }}
                            </p>
                        </div>

                        @if($appointment->confirmed_at || $appointment->rejected_at)
                            <div>
                                <label class="text-sm font-medium text-gray-600">Owner Response</label>
                                <p class="text-lg font-semibold text-brand-dark">
                                    {{ ($appointment->confirmed_at ?: $appointment->rejected_at)->format('F j, Y') }}
                                </p>
                                <p class="text-gray-600">
                                    {{ ($appointment->confirmed_at ?: $appointment->rejected_at)->diffForHumans() }}
                                </p>
                            </div>
                        @endif
                    </div>

                    @if($appointment->client_message)
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <label class="text-sm font-medium text-gray-600">Your Notes</label>
                            <p class="text-brand-dark mt-2 bg-gray-50 p-3 rounded">{{ $appointment->client_message }}</p>
                        </div>
                    @endif

                    @if($appointment->owner_response)
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <label class="text-sm font-medium text-gray-600">Owner's Response</label>
                            <p class="text-brand-dark mt-2 bg-blue-50 p-3 rounded">{{ $appointment->owner_response }}</p>
                        </div>
                    @endif
                </div>

                <!-- Owner Actions (if user is owner) -->
                @if(Auth::id() === $appointment->owner_id && $appointment->status === 'pending')
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-brand-dark mb-4">Respond to Appointment Request</h3>
                        
                        <form action="{{ route('appointments.update-status', $appointment) }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PATCH')
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Response Notes (Optional)</label>
                                <textarea name="owner_response" rows="3"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-beige focus:border-transparent"
                                          placeholder="Add any additional information or instructions...">{{ old('owner_response') }}</textarea>
                            </div>
                            
                            <div class="flex space-x-4">
                                <button type="submit" name="status" value="confirmed" 
                                        class="flex-1 bg-green-600 text-white py-3 px-6 rounded-lg hover:bg-green-700 transition duration-300 font-semibold">
                                    <i class="fas fa-check mr-2"></i>Confirm Appointment
                                </button>
                                
                                <button type="submit" name="status" value="rejected" 
                                        class="flex-1 bg-red-600 text-white py-3 px-6 rounded-lg hover:bg-red-700 transition duration-300 font-semibold">
                                    <i class="fas fa-times mr-2"></i>Reject Appointment
                                </button>
                            </div>
                        </form>
                    </div>
                @endif

                <!-- Next Steps for Client -->
                @if(Auth::id() === $appointment->client_id)
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-brand-dark mb-4">What's Next?</h3>
                        
                        @if($appointment->status === 'pending')
                            <div class="bg-yellow-50 p-4 rounded-lg">
                                <div class="flex items-start">
                                    <i class="fas fa-clock text-yellow-500 mt-1 mr-3"></i>
                                    <div>
                                        <p class="font-semibold text-yellow-800 mb-2">Waiting for Owner Response</p>
                                        <p class="text-yellow-700 text-sm">
                                            Your appointment request has been sent to the property owner. 
                                            You'll receive an email notification once they respond.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @elseif($appointment->status === 'confirmed')
                            <div class="bg-green-50 p-4 rounded-lg mb-4">
                                <div class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <div>
                                        <p class="font-semibold text-green-800 mb-2">Appointment Confirmed!</p>
                                        <p class="text-green-700 text-sm">
                                            Your visit has been confirmed. Please arrive on time and bring a valid ID.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Payment Button -->
                            <div class="text-center">
                                <a href="{{ route('payments.create', $appointment->property) }}" 
                                   class="inline-block bg-brand-dark text-white py-3 px-8 rounded-lg hover:bg-opacity-90 transition duration-300 font-semibold">
                                    <i class="fas fa-credit-card mr-2"></i>Proceed to Payment (Step 3)
                                </a>
                                <p class="text-sm text-gray-600 mt-2">Complete your property acquisition process</p>
                            </div>
                        @elseif($appointment->status === 'rejected')
                            <div class="bg-red-50 p-4 rounded-lg">
                                <div class="flex items-start">
                                    <i class="fas fa-times-circle text-red-500 mt-1 mr-3"></i>
                                    <div>
                                        <p class="font-semibold text-red-800 mb-2">Appointment Not Available</p>
                                        <p class="text-red-700 text-sm">
                                            Unfortunately, this appointment time is not available. 
                                            You can schedule a new appointment with different date/time.
                                        </p>
                                        <a href="{{ route('appointments.create', $appointment->property) }}" 
                                           class="inline-block mt-3 bg-brand-dark text-white py-2 px-4 rounded text-sm hover:bg-opacity-90">
                                            Schedule New Appointment
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Property Card -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <img src="{{ $appointment->property->featured_image_url }}" alt="{{ $appointment->property->title }}" class="w-full h-48 object-cover">
                    
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-brand-dark mb-2">{{ $appointment->property->title }}</h3>
                        
                        <div class="space-y-2 text-sm text-gray-600 mb-4">
                            <div class="flex items-center">
                                <i class="fas fa-map-marker-alt mr-2 text-brand-beige"></i>
                                {{ $appointment->property->address }}, {{ $appointment->property->city->name }}
                            </div>
                            
                            <div class="flex items-center">
                                <i class="fas fa-dollar-sign mr-2 text-brand-beige"></i>
                                {{ $appointment->property->formatted_price }}
                            </div>
                        </div>
                        
                        <a href="{{ route('properties.show', $appointment->property) }}" 
                           class="block text-center bg-brand-beige text-brand-dark py-2 rounded hover:bg-opacity-80 transition duration-300">
                            View Property Details
                        </a>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-brand-dark mb-4">
                        @if(Auth::id() === $appointment->client_id)
                            Property Owner
                        @else
                            Client Information
                        @endif
                    </h3>
                    
                    @if(Auth::id() === $appointment->client_id)
                        <!-- Show owner info to client -->
                        <div class="flex items-center space-x-4 mb-4">
                            <img src="{{ $appointment->property->owner->profile_picture_url }}" alt="{{ $appointment->property->owner->name }}" 
                                 class="w-12 h-12 rounded-full">
                            <div>
                                <div class="font-semibold text-brand-dark">{{ $appointment->property->owner->name }}</div>
                                <div class="text-sm text-gray-600">Property Owner</div>
                            </div>
                        </div>
                        
                        <div class="text-sm text-gray-600 space-y-2">
                            <div class="flex items-center">
                                <i class="fas fa-envelope mr-2 text-brand-beige"></i>
                                {{ $appointment->property->owner->email }}
                            </div>
                            
                            @if($appointment->property->owner->phone)
                                <div class="flex items-center">
                                    <i class="fas fa-phone mr-2 text-brand-beige"></i>
                                    {{ $appointment->property->owner->phone }}
                                </div>
                            @endif
                        </div>
                    @else
                        <!-- Show client info to owner -->
                        <div class="flex items-center space-x-4 mb-4">
                            <img src="{{ $appointment->client->profile_picture_url }}" alt="{{ $appointment->client->name }}" 
                                 class="w-12 h-12 rounded-full">
                            <div>
                                <div class="font-semibold text-brand-dark">{{ $appointment->client->name }}</div>
                                <div class="text-sm text-gray-600">Client</div>
                            </div>
                        </div>
                        
                        <div class="text-sm text-gray-600 space-y-2">
                            <div class="flex items-center">
                                <i class="fas fa-envelope mr-2 text-brand-beige"></i>
                                {{ $appointment->client->email }}
                            </div>
                            
                            @if($appointment->client->phone)
                                <div class="flex items-center">
                                    <i class="fas fa-phone mr-2 text-brand-beige"></i>
                                    {{ $appointment->client->phone }}
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Process Steps -->
                <div class="bg-blue-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-blue-800 mb-3">
                        <i class="fas fa-route mr-2"></i>Process Steps
                    </h3>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center text-green-700">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span>✓ Step 1: Contact Owner - Completed</span>
                        </div>
                        <div class="flex items-center {{ $appointment->status === 'confirmed' ? 'text-green-700' : 'text-blue-700' }}">
                            <i class="fas fa-{{ $appointment->status === 'confirmed' ? 'check-circle' : 'clock' }} mr-2"></i>
                            <span>{{ $appointment->status === 'confirmed' ? '✓' : '→' }} Step 2: Schedule Visit - {{ ucfirst($appointment->status) }}</span>
                        </div>
                        <div class="flex items-center {{ $appointment->status === 'confirmed' ? 'text-blue-700 font-semibold' : 'text-gray-500' }}">
                            <i class="fas fa-{{ $appointment->status === 'confirmed' ? 'arrow-right' : 'circle' }} mr-2"></i>
                            <span>{{ $appointment->status === 'confirmed' ? '→' : '' }} Step 3: Complete Payment - {{ $appointment->status === 'confirmed' ? 'Ready' : 'Pending' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
