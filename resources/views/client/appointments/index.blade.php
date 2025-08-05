@extends('layouts.dashboard')

@section('title', 'My Appointments - Client Dashboard')
@section('page-title', 'My Appointments')

@section('breadcrumb')
<a href="{{ route('client.dashboard') }}" class="hover:text-brand-dark">Dashboard</a>
<span class="mx-2">/</span>
<span>My Appointments</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex justify-between items-center">
        <div>
            <p class="text-gray-600">Manage your property viewing appointments</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('home') }}" class="btn-primary">
                <i class="fas fa-search mr-2"></i>Browse Properties
            </a>
            <button class="btn-outline">
                <i class="fas fa-calendar mr-2"></i>Calendar View
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="dashboard-stat">
            <div class="flex items-center justify-between">
                <div>
                    <div class="dashboard-stat-value">{{ $totalAppointments }}</div>
                    <div class="dashboard-stat-label">Total Appointments</div>
                </div>
                <div class="text-blue-500">
                    <i class="fas fa-calendar text-3xl"></i>
                </div>
            </div>
        </div>

        <div class="dashboard-stat">
            <div class="flex items-center justify-between">
                <div>
                    <div class="dashboard-stat-value">{{ $upcomingAppointments }}</div>
                    <div class="dashboard-stat-label">Upcoming</div>
                </div>
                <div class="text-green-500">
                    <i class="fas fa-clock text-3xl"></i>
                </div>
            </div>
        </div>

        <div class="dashboard-stat">
            <div class="flex items-center justify-between">
                <div>
                    <div class="dashboard-stat-value">{{ $confirmedAppointments }}</div>
                    <div class="dashboard-stat-label">Confirmed</div>
                </div>
                <div class="text-purple-500">
                    <i class="fas fa-check-circle text-3xl"></i>
                </div>
            </div>
        </div>

        <div class="dashboard-stat">
            <div class="flex items-center justify-between">
                <div>
                    <div class="dashboard-stat-value">{{ $pendingAppointments }}</div>
                    <div class="dashboard-stat-label">Pending Response</div>
                </div>
                <div class="text-yellow-500">
                    <i class="fas fa-hourglass-half text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- All Appointments -->
    <div class="dashboard-card">
        <div class="dashboard-card-header">
            <h3 class="dashboard-card-title">My Appointments</h3>
            <div class="flex space-x-2">
                <select class="form-input text-sm">
                    <option>All Status</option>
                    <option>Confirmed</option>
                    <option>Pending</option>
                    <option>Cancelled</option>
                </select>
            </div>
        </div>
        
        @if($appointments->count() > 0)
            <!-- Appointments List -->
            <div class="space-y-4">
                @foreach($appointments as $appointment)
                    <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-3">
                                    <h4 class="text-lg font-semibold text-brand-dark">
                                        {{ $appointment->property->title }}
                                    </h4>
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                                        @if($appointment->status === 'confirmed') bg-green-100 text-green-800
                                        @elseif($appointment->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($appointment->status === 'rejected') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
                                    <div>
                                        <i class="fas fa-calendar mr-2 text-brand-beige"></i>
                                        <strong>Date:</strong> {{ $appointment->appointment_date->format('M j, Y') }}
                                    </div>
                                    <div>
                                        <i class="fas fa-clock mr-2 text-brand-beige"></i>
                                        <strong>Time:</strong> {{ $appointment->appointment_date->format('g:i A') }}
                                    </div>
                                    <div>
                                        <i class="fas fa-user mr-2 text-brand-beige"></i>
                                        <strong>Owner:</strong> {{ $appointment->owner->name }}
                                    </div>
                                </div>

                                @if($appointment->client_message)
                                    <div class="mt-3 p-3 bg-gray-50 rounded">
                                        <p class="text-sm text-gray-700">
                                            <strong>Your Message:</strong> {{ $appointment->client_message }}
                                        </p>
                                    </div>
                                @endif

                                @if($appointment->owner_response)
                                    <div class="mt-3 p-3 bg-blue-50 rounded">
                                        <p class="text-sm text-blue-700">
                                            <strong>Owner Response:</strong> {{ $appointment->owner_response }}
                                        </p>
                                    </div>
                                @endif
                            </div>

                            <div class="flex flex-col space-y-2 ml-4">
                                <a href="{{ route('properties.show', $appointment->property) }}"
                                   class="btn-outline text-sm">
                                    <i class="fas fa-eye mr-1"></i>View Property
                                </a>

                                @if($appointment->status === 'pending')
                                    <button class="btn-outline text-red-600 border-red-600 hover:bg-red-600 hover:text-white text-sm">
                                        <i class="fas fa-times mr-1"></i>Cancel
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="max-w-md mx-auto">
                    <i class="fas fa-calendar-check text-6xl text-gray-400 mb-6"></i>
                    <h3 class="text-2xl font-semibold text-gray-600 mb-4">No Appointments Scheduled</h3>
                    <p class="text-gray-500 mb-8">Start browsing properties and request appointments to view them in person.</p>

                    <div class="space-y-4">
                        <a href="{{ route('home') }}" class="btn-primary inline-block">
                            <i class="fas fa-search mr-2"></i>Browse Properties
                        </a>

                        <div class="text-sm text-gray-500">
                            <p>💡 Tip: You can request appointments directly from property detail pages</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>



    <!-- How It Works -->
    <div class="dashboard-card">
        <div class="dashboard-card-header">
            <h3 class="dashboard-card-title">How Property Appointments Work</h3>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center p-4 bg-blue-50 rounded-lg">
                <div class="w-12 h-12 bg-blue-500 text-white rounded-full flex items-center justify-center mx-auto mb-3">
                    <span class="font-bold">1</span>
                </div>
                <h4 class="font-semibold text-blue-900 mb-2">Request Appointment</h4>
                <p class="text-sm text-blue-700">Browse properties and click "Request Appointment" on any property you're interested in.</p>
            </div>
            
            <div class="text-center p-4 bg-yellow-50 rounded-lg">
                <div class="w-12 h-12 bg-yellow-500 text-white rounded-full flex items-center justify-center mx-auto mb-3">
                    <span class="font-bold">2</span>
                </div>
                <h4 class="font-semibold text-yellow-900 mb-2">Wait for Confirmation</h4>
                <p class="text-sm text-yellow-700">The property owner will review your request and confirm or suggest alternative times.</p>
            </div>
            
            <div class="text-center p-4 bg-green-50 rounded-lg">
                <div class="w-12 h-12 bg-green-500 text-white rounded-full flex items-center justify-center mx-auto mb-3">
                    <span class="font-bold">3</span>
                </div>
                <h4 class="font-semibold text-green-900 mb-2">Visit Property</h4>
                <p class="text-sm text-green-700">Attend your confirmed appointment and explore the property with the owner.</p>
            </div>
        </div>
    </div>
</div>
@endsection
