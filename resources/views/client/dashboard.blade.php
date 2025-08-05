@extends('layouts.dashboard')

@section('title', 'Client Dashboard - Real Estate Platform')
@section('page-title', 'Welcome back, ' . auth()->user()->name)

@section('content')
<div class="space-y-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="dashboard-stat">
            <div class="flex items-center justify-between">
                <div>
                    <div class="dashboard-stat-value">{{ $stats['favorites_count'] }}</div>
                    <div class="dashboard-stat-label">Favorite Properties</div>
                </div>
                <div class="text-brand-beige">
                    <i class="fas fa-heart text-3xl"></i>
                </div>
            </div>
        </div>

        <div class="dashboard-stat">
            <div class="flex items-center justify-between">
                <div>
                    <div class="dashboard-stat-value">{{ $stats['appointments_count'] }}</div>
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
                    <div class="dashboard-stat-value">{{ $stats['pending_appointments'] }}</div>
                    <div class="dashboard-stat-label">Pending Appointments</div>
                </div>
                <div class="text-yellow-500">
                    <i class="fas fa-clock text-3xl"></i>
                </div>
            </div>
        </div>

        <div class="dashboard-stat">
            <div class="flex items-center justify-between">
                <div>
                    <div class="dashboard-stat-value">{{ $stats['confirmed_appointments'] }}</div>
                    <div class="dashboard-stat-label">Confirmed Appointments</div>
                </div>
                <div class="text-green-500">
                    <i class="fas fa-check-circle text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Favorites -->
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <h3 class="dashboard-card-title">Recent Favorites</h3>
                <a href="{{ route('client.favorites.index') }}" class="text-brand-beige hover:text-brand-dark text-sm font-medium">
                    View All
                </a>
            </div>
            
            @if($recentFavorites->count() > 0)
                <div class="space-y-4">
                    @foreach($recentFavorites->take(3) as $favorite)
                        <div class="flex items-center space-x-4 p-3 bg-gray-50 rounded-lg">
                            <img src="{{ $favorite->property->featured_image_url }}" 
                                 alt="{{ $favorite->property->title }}" 
                                 class="w-16 h-16 object-cover rounded-lg">
                            <div class="flex-1">
                                <h4 class="font-semibold text-brand-dark">{{ Str::limit($favorite->property->title, 30) }}</h4>
                                <p class="text-sm text-gray-600">{{ $favorite->property->city->name }}</p>
                                <p class="text-sm font-semibold text-brand-beige">{{ $favorite->property->formatted_price }}</p>
                            </div>
                            <a href="{{ route('properties.show', $favorite->property) }}" class="btn-primary text-xs px-3 py-1">
                                View
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-heart text-4xl mb-3"></i>
                    <p>No favorite properties yet</p>
                    <a href="{{ route('home') }}" class="btn-primary mt-3 text-sm">Browse Properties</a>
                </div>
            @endif
        </div>

        <!-- Upcoming Appointments -->
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <h3 class="dashboard-card-title">Upcoming Appointments</h3>
                <a href="{{ route('client.appointments.index') }}" class="text-brand-beige hover:text-brand-dark text-sm font-medium">
                    View All
                </a>
            </div>
            
            @if($upcomingAppointments->count() > 0)
                <div class="space-y-4">
                    @foreach($upcomingAppointments->take(3) as $appointment)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <h4 class="font-semibold text-brand-dark">{{ Str::limit($appointment->property->title, 25) }}</h4>
                                <p class="text-sm text-gray-600">with {{ $appointment->owner->name }}</p>
                                <p class="text-sm text-brand-beige">{{ $appointment->appointment_date->format('M d, Y - H:i') }}</p>
                            </div>
                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                                Confirmed
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-calendar text-4xl mb-3"></i>
                    <p>No upcoming appointments</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Recommended Properties -->
    @if($recommendedProperties->count() > 0)
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <h3 class="dashboard-card-title">Recommended for You</h3>
                <a href="{{ route('home') }}" class="text-brand-beige hover:text-brand-dark text-sm font-medium">
                    Browse More
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($recommendedProperties as $property)
                    <div class="property-card">
                        <div class="relative">
                            <img src="{{ $property->featured_image_url }}" 
                                 alt="{{ $property->title }}" 
                                 class="w-full h-32 object-cover">
                            <div class="absolute top-2 left-2">
                                <span class="property-status {{ $property->isForSale() ? 'status-sale' : 'status-rent' }}">
                                    {{ $property->isForSale() ? 'Sale' : 'Rent' }}
                                </span>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="property-price text-lg mb-2">{{ $property->formatted_price }}</div>
                            <h4 class="font-semibold text-brand-dark mb-1">{{ Str::limit($property->title, 20) }}</h4>
                            <p class="text-sm text-gray-600 mb-3">{{ $property->city->name }}</p>
                            <a href="{{ route('properties.show', $property) }}" class="btn-primary w-full text-center text-sm py-2">
                                View Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Recent Activity -->
    <div class="dashboard-card">
        <div class="dashboard-card-header">
            <h3 class="dashboard-card-title">Recent Activity</h3>
        </div>
        
        @if($recentActivity->count() > 0)
            <div class="space-y-3">
                @foreach($recentActivity as $activity)
                    <div class="flex items-center space-x-4 p-3 border-l-4 border-brand-beige bg-gray-50">
                        <div class="text-brand-beige">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm">
                                <span class="font-semibold">Appointment {{ $activity->status }}</span> 
                                for {{ $activity->property->title }}
                            </p>
                            <p class="text-xs text-gray-500">{{ $activity->created_at->diffForHumans() }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full
                            {{ $activity->status === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $activity->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $activity->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ ucfirst($activity->status) }}
                        </span>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 text-gray-500">
                <i class="fas fa-history text-4xl mb-3"></i>
                <p>No recent activity</p>
            </div>
        @endif
    </div>
</div>
@endsection
