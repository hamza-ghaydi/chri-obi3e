@extends('layouts.dashboard')

@section('title', $property->title . ' - Owner Dashboard')
@section('page-title', 'Property Details')

@section('breadcrumb')
<a href="{{ route('owner.dashboard') }}" class="hover:text-brand-dark">Dashboard</a>
<span class="mx-2">/</span>
<a href="{{ route('owner.properties.index') }}" class="hover:text-brand-dark">My Properties</a>
<span class="mx-2">/</span>
<span>{{ Str::limit($property->title, 30) }}</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Property Header -->
    <div class="dashboard-card">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-bold text-brand-dark mb-2">{{ $property->title }}</h1>
                <div class="flex items-center space-x-4 text-sm text-gray-600">
                    <span><i class="fas fa-map-marker-alt mr-1"></i>{{ $property->address }}, {{ $property->city->name }}</span>
                    <span><i class="fas fa-tag mr-1"></i>{{ $property->category->name }}</span>
                    <span><i class="fas fa-calendar mr-1"></i>Created {{ $property->created_at->format('M d, Y') }}</span>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <span class="px-3 py-1 rounded-full text-sm font-semibold
                    {{ $property->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                    {{ $property->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                    {{ $property->status === 'draft' ? 'bg-gray-100 text-gray-800' : '' }}
                    {{ $property->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                    {{ ucfirst($property->status) }}
                </span>
                
                <div class="property-price text-2xl">{{ $property->formatted_price }}</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Property Images -->
            @if($property->images->count() > 0)
                <div class="dashboard-card">
                    <div class="dashboard-card-header">
                        <h3 class="dashboard-card-title">Property Photos</h3>
                        <span class="text-sm text-gray-600">{{ $property->images->count() }} photos</span>
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($property->images as $image)
                            <div class="relative">
                                <img src="{{ $image->image_url }}" alt="{{ $image->alt_text }}" class="w-full h-32 object-cover rounded-lg">
                                @if($image->is_featured)
                                    <div class="absolute top-2 left-2 bg-brand-beige text-brand-dark text-xs px-2 py-1 rounded">
                                        Featured
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Property Details -->
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <h3 class="dashboard-card-title">Property Information</h3>
                </div>
                
                <div class="space-y-6">
                    <!-- Basic Info -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @if($property->bedrooms)
                            <div class="text-center p-4 bg-gray-50 rounded-lg">
                                <i class="fas fa-bed text-2xl text-brand-dark mb-2"></i>
                                <div class="font-semibold">{{ $property->bedrooms }}</div>
                                <div class="text-sm text-gray-600">Bedroom{{ $property->bedrooms > 1 ? 's' : '' }}</div>
                            </div>
                        @endif
                        
                        @if($property->bathrooms)
                            <div class="text-center p-4 bg-gray-50 rounded-lg">
                                <i class="fas fa-bath text-2xl text-brand-dark mb-2"></i>
                                <div class="font-semibold">{{ $property->bathrooms }}</div>
                                <div class="text-sm text-gray-600">Bathroom{{ $property->bathrooms > 1 ? 's' : '' }}</div>
                            </div>
                        @endif
                        
                        @if($property->area)
                            <div class="text-center p-4 bg-gray-50 rounded-lg">
                                <i class="fas fa-ruler-combined text-2xl text-brand-dark mb-2"></i>
                                <div class="font-semibold">{{ number_format($property->area) }}</div>
                                <div class="text-sm text-gray-600">m² Area</div>
                            </div>
                        @endif
                        
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <i class="fas fa-{{ $property->isForSale() ? 'dollar-sign' : 'calendar' }} text-2xl text-brand-dark mb-2"></i>
                            <div class="font-semibold">{{ $property->isForSale() ? 'Sale' : 'Rent' }}</div>
                            <div class="text-sm text-gray-600">Listing Type</div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <h4 class="font-semibold text-brand-dark mb-3">Description</h4>
                        <div class="prose max-w-none text-gray-700">
                            {!! nl2br(e($property->description)) !!}
                        </div>
                    </div>

                    <!-- Features -->
                    @if($property->features && count($property->features) > 0)
                        <div>
                            <h4 class="font-semibold text-brand-dark mb-3">Features & Amenities</h4>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                @foreach($property->features as $feature)
                                    <div class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-2"></i>
                                        <span>{{ $feature }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Appointments -->
            @if($property->appointments->count() > 0)
                <div class="dashboard-card">
                    <div class="dashboard-card-header">
                        <h3 class="dashboard-card-title">Recent Appointments</h3>
                        <a href="{{ route('owner.appointments.index') }}" class="text-brand-beige hover:text-brand-dark text-sm">View All</a>
                    </div>
                    
                    <div class="space-y-3">
                        @foreach($property->appointments->take(5) as $appointment)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <img src="{{ $appointment->client->profile_picture_url }}" alt="{{ $appointment->client->name }}" class="w-10 h-10 rounded-full">
                                    <div>
                                        <div class="font-semibold">{{ $appointment->client->name }}</div>
                                        <div class="text-sm text-gray-600">{{ $appointment->appointment_date->format('M d, Y - H:i') }}</div>
                                    </div>
                                </div>
                                <span class="px-2 py-1 text-xs rounded-full
                                    {{ $appointment->status === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $appointment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $appointment->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <h3 class="dashboard-card-title">Quick Actions</h3>
                </div>
                
                <div class="space-y-3">
                    <a href="{{ route('owner.properties.edit', $property) }}" class="btn-primary w-full text-center">
                        <i class="fas fa-edit mr-2"></i>Edit Property
                    </a>
                    
                    @if($property->status === 'approved' && $property->payment_completed)
                        <a href="{{ route('properties.show', $property) }}" target="_blank" class="btn-outline w-full text-center">
                            <i class="fas fa-external-link-alt mr-2"></i>View Public Page
                        </a>
                    @endif
                    
                    <form action="{{ route('owner.properties.destroy', $property) }}" method="POST" class="w-full">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-outline w-full text-red-600 border-red-600 hover:bg-red-600 hover:text-white"
                                onclick="return confirm('Are you sure you want to delete this property?')">
                            <i class="fas fa-trash mr-2"></i>Delete Property
                        </button>
                    </form>
                </div>
            </div>

            <!-- Property Statistics -->
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <h3 class="dashboard-card-title">Property Stats</h3>
                </div>
                
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Views:</span>
                        <span class="font-semibold">0</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">Favorites:</span>
                        <span class="font-semibold">{{ $property->favorites->count() }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">Appointments:</span>
                        <span class="font-semibold">{{ $property->appointments->count() }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">Inquiries:</span>
                        <span class="font-semibold">0</span>
                    </div>
                </div>
            </div>

            <!-- Payment Status -->
            @if($property->status === 'approved')
                <div class="dashboard-card">
                    <div class="dashboard-card-header">
                        <h3 class="dashboard-card-title">Payment Status</h3>
                    </div>
                    
                    @if($property->payment_completed)
                        <div class="text-center py-4">
                            <i class="fas fa-check-circle text-green-500 text-3xl mb-2"></i>
                            <p class="text-green-600 font-semibold">Payment Completed</p>
                            <p class="text-sm text-gray-600">Your property is live!</p>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-credit-card text-yellow-500 text-3xl mb-2"></i>
                            <p class="text-yellow-600 font-semibold">Payment Required</p>
                            <p class="text-sm text-gray-600 mb-4">Pay the listing fee to publish your property</p>
                            <a href="{{ route('owner.payments.create') }}?property={{ $property->id }}" class="btn-primary">
                                <i class="fas fa-credit-card mr-2"></i>Pay Now
                            </a>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Property Information -->
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <h3 class="dashboard-card-title">Property Details</h3>
                </div>
                
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Property ID:</span>
                        <span class="font-semibold">#{{ $property->id }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">Created:</span>
                        <span class="font-semibold">{{ $property->created_at->format('M d, Y') }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">Last Updated:</span>
                        <span class="font-semibold">{{ $property->updated_at->format('M d, Y') }}</span>
                    </div>
                    
                    @if($property->approved_at)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Approved:</span>
                            <span class="font-semibold">{{ $property->approved_at->format('M d, Y') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
