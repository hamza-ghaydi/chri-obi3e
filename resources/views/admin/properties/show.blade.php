@extends('layouts.dashboard')

@section('title', 'Review Property - Admin Dashboard')
@section('page-title', 'Property Review')

@section('breadcrumb')
<a href="{{ route('admin.dashboard') }}" class="hover:text-brand-dark">Dashboard</a>
<span class="mx-2">/</span>
<a href="{{ route('admin.properties.index') }}" class="hover:text-brand-dark">Properties</a>
<span class="mx-2">/</span>
<span>Review Property</span>
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
                    <span><i class="fas fa-calendar mr-1"></i>Submitted {{ $property->created_at->format('M d, Y') }}</span>
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
                        <div class="prose max-w-none text-gray-700 bg-gray-50 p-4 rounded-lg">
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

            <!-- Owner Information -->
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <h3 class="dashboard-card-title">Property Owner</h3>
                </div>
                
                <div class="flex items-center space-x-4">
                    <img src="{{ $property->owner->profile_picture_url }}" alt="{{ $property->owner->name }}" class="w-16 h-16 rounded-full">
                    <div>
                        <div class="font-semibold text-lg">{{ $property->owner->name }}</div>
                        <div class="text-gray-600">{{ $property->owner->email }}</div>
                        @if($property->owner->phone)
                            <div class="text-gray-600">{{ $property->owner->phone }}</div>
                        @endif
                        <div class="text-sm text-gray-500">Member since {{ $property->owner->created_at->format('M Y') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Review Actions -->
            @if($property->status === 'pending')
                <div class="dashboard-card">
                    <div class="dashboard-card-header">
                        <h3 class="dashboard-card-title">Review Actions</h3>
                    </div>
                    
                    <form action="{{ route('admin.properties.update-status', $property) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <label class="form-label">Decision *</label>
                            <select name="status" class="form-input" required>
                                <option value="">Select Action</option>
                                <option value="approved">Approve Property</option>
                                <option value="rejected">Reject Property</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="form-label">Admin Notes</label>
                            <textarea name="admin_notes" rows="4" placeholder="Add notes about your decision..." class="form-input"></textarea>
                        </div>
                        
                        <button type="submit" class="btn-primary w-full">
                            <i class="fas fa-check mr-2"></i>Submit Review
                        </button>
                    </form>
                </div>
            @else
                <div class="dashboard-card">
                    <div class="dashboard-card-header">
                        <h3 class="dashboard-card-title">Review Status</h3>
                    </div>
                    
                    <div class="text-center py-4">
                        <i class="fas fa-{{ $property->status === 'approved' ? 'check-circle text-green-500' : 'times-circle text-red-500' }} text-4xl mb-3"></i>
                        <p class="font-semibold text-lg">{{ ucfirst($property->status) }}</p>
                        
                        @if($property->approved_at)
                            <p class="text-sm text-gray-600">Approved on {{ $property->approved_at->format('M d, Y') }}</p>
                        @elseif($property->rejected_at)
                            <p class="text-sm text-gray-600">Rejected on {{ $property->rejected_at->format('M d, Y') }}</p>
                        @endif
                        
                        @if($property->reviewer)
                            <p class="text-sm text-gray-600">by {{ $property->reviewer->name }}</p>
                        @endif
                    </div>
                    
                    @if($property->admin_notes)
                        <div class="border-t pt-4">
                            <h4 class="font-semibold text-sm mb-2">Admin Notes:</h4>
                            <p class="text-sm text-gray-700 bg-gray-50 p-3 rounded">{{ $property->admin_notes }}</p>
                        </div>
                    @endif
                </div>
            @endif

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
                        <span class="text-gray-600">Images:</span>
                        <span class="font-semibold">{{ $property->images->count() }}</span>
                    </div>
                </div>
            </div>

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
                        <span class="text-gray-600">Submitted:</span>
                        <span class="font-semibold">{{ $property->created_at->format('M d, Y') }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">Last Updated:</span>
                        <span class="font-semibold">{{ $property->updated_at->format('M d, Y') }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">Payment Status:</span>
                        <span class="font-semibold {{ $property->payment_completed ? 'text-green-600' : 'text-yellow-600' }}">
                            {{ $property->payment_completed ? 'Completed' : 'Pending' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <h3 class="dashboard-card-title">Quick Actions</h3>
                </div>
                
                <div class="space-y-3">
                    <a href="{{ route('admin.properties.index') }}" class="btn-outline w-full text-center">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Properties
                    </a>
                    
                    @if($property->status === 'approved' && $property->payment_completed)
                        <a href="{{ route('properties.show', $property) }}" target="_blank" class="btn-outline w-full text-center">
                            <i class="fas fa-external-link-alt mr-2"></i>View Public Page
                        </a>
                    @endif
                    
                    <form action="{{ route('admin.properties.destroy', $property) }}" method="POST" class="w-full">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-outline w-full text-red-600 border-red-600 hover:bg-red-600 hover:text-white"
                                onclick="return confirm('Are you sure you want to delete this property permanently?')">
                            <i class="fas fa-trash mr-2"></i>Delete Property
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
