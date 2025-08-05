@extends('layouts.dashboard')

@section('title', 'My Properties - Owner Dashboard')
@section('page-title', 'My Properties')

@section('breadcrumb')
<a href="{{ route('owner.dashboard') }}" class="hover:text-brand-dark">Dashboard</a>
<span class="mx-2">/</span>
<span>My Properties</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex justify-between items-center">
        <div>
            <p class="text-gray-600">Manage your property listings</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('owner.properties.create') }}" class="btn-primary">
                <i class="fas fa-plus mr-2"></i>Add New Property
            </a>
            <button class="btn-outline">
                <i class="fas fa-filter mr-2"></i>Filter
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="dashboard-stat">
            <div class="flex items-center justify-between">
                <div>
                    <div class="dashboard-stat-value">{{ $stats['total'] }}</div>
                    <div class="dashboard-stat-label">Total Properties</div>
                </div>
                <div class="text-blue-500">
                    <i class="fas fa-building text-3xl"></i>
                </div>
            </div>
        </div>

        <div class="dashboard-stat">
            <div class="flex items-center justify-between">
                <div>
                    <div class="dashboard-stat-value">{{ $stats['published'] }}</div>
                    <div class="dashboard-stat-label">Published</div>
                </div>
                <div class="text-green-500">
                    <i class="fas fa-check-circle text-3xl"></i>
                </div>
            </div>
        </div>

        <div class="dashboard-stat">
            <div class="flex items-center justify-between">
                <div>
                    <div class="dashboard-stat-value">{{ $stats['pending'] }}</div>
                    <div class="dashboard-stat-label">Pending Approval</div>
                </div>
                <div class="text-yellow-500">
                    <i class="fas fa-clock text-3xl"></i>
                </div>
            </div>
        </div>

        <div class="dashboard-stat">
            <div class="flex items-center justify-between">
                <div>
                    <div class="dashboard-stat-value">{{ $stats['draft'] }}</div>
                    <div class="dashboard-stat-label">Draft Properties</div>
                </div>
                <div class="text-purple-500">
                    <i class="fas fa-edit text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Properties Grid/List -->
    <div class="dashboard-card">
        <div class="dashboard-card-header">
            <h3 class="dashboard-card-title">Your Properties</h3>
            <div class="flex space-x-2">
                <select class="form-input text-sm">
                    <option>All Status</option>
                    <option>Published</option>
                    <option>Pending</option>
                    <option>Draft</option>
                </select>
                <button class="btn-outline text-sm">
                    <i class="fas fa-th mr-1"></i>Grid
                </button>
                <button class="btn-outline text-sm">
                    <i class="fas fa-list mr-1"></i>List
                </button>
            </div>
        </div>
        
        @if($properties->count() > 0)
            <!-- Properties Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($properties as $property)
                    <div class="property-card relative">
                        <!-- Property Image -->
                        <div class="relative">
                            <img src="{{ $property->featured_image_url }}"
                                 alt="{{ $property->title }}"
                                 class="property-image">

                            <!-- Status Badge -->
                            <div class="absolute top-4 left-4">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    {{ $property->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $property->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $property->status === 'draft' ? 'bg-gray-100 text-gray-800' : '' }}
                                    {{ $property->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($property->status) }}
                                </span>
                            </div>

                            <!-- Listing Type Badge -->
                            <div class="absolute top-4 right-4">
                                <span class="property-status {{ $property->isForSale() ? 'status-sale' : 'status-rent' }}">
                                    {{ $property->isForSale() ? 'For Sale' : 'For Rent' }}
                                </span>
                            </div>
                        </div>

                        <!-- Property Details -->
                        <div class="p-6">
                            <!-- Price -->
                            <div class="property-price mb-3">{{ $property->formatted_price }}</div>

                            <!-- Title -->
                            <h3 class="text-lg font-semibold text-brand-dark mb-2 line-clamp-2">
                                {{ $property->title }}
                            </h3>

                            <!-- Location -->
                            <div class="flex items-center text-gray-600 mb-3">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                <span class="text-sm">{{ $property->city->name }}</span>
                            </div>

                            <!-- Property Features -->
                            <div class="flex items-center justify-between text-sm text-gray-600 mb-4">
                                @if($property->bedrooms)
                                    <div class="flex items-center">
                                        <i class="fas fa-bed mr-1"></i>
                                        <span>{{ $property->bedrooms }}</span>
                                    </div>
                                @endif

                                @if($property->bathrooms)
                                    <div class="flex items-center">
                                        <i class="fas fa-bath mr-1"></i>
                                        <span>{{ $property->bathrooms }}</span>
                                    </div>
                                @endif

                                @if($property->area)
                                    <div class="flex items-center">
                                        <i class="fas fa-ruler-combined mr-1"></i>
                                        <span>{{ $property->area }}m²</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-2">
                                <a href="{{ route('owner.properties.show', $property) }}" class="btn-outline flex-1 text-center text-sm py-2">
                                    <i class="fas fa-eye mr-1"></i>View
                                </a>

                                <a href="{{ route('owner.properties.edit', $property) }}" class="btn-primary flex-1 text-center text-sm py-2">
                                    <i class="fas fa-edit mr-1"></i>Edit
                                </a>

                                <form action="{{ route('owner.properties.destroy', $property) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-outline text-red-600 border-red-600 hover:bg-red-600 hover:text-white text-sm py-2 px-3"
                                            onclick="return confirm('Are you sure you want to delete this property?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $properties->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="max-w-md mx-auto">
                    <i class="fas fa-home text-6xl text-gray-400 mb-6"></i>
                    <h3 class="text-2xl font-semibold text-gray-600 mb-4">No Properties Yet</h3>
                    <p class="text-gray-500 mb-8">Start building your property portfolio by adding your first listing.</p>

                    <div class="space-y-4">
                        {{-- <a href="{{ route('owner.properties.create') }}" class="btn-primary inline-block"> --}}
                            <i class="fas fa-plus mr-2"></i>Add Your First Property
                        </a>

                        <div class="text-sm text-gray-500">
                            <p>💡 Tip: High-quality photos and detailed descriptions get more views</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Quick Tips -->
    <div class="dashboard-card">
        <div class="dashboard-card-header">
            <h3 class="dashboard-card-title">Property Management Tips</h3>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="text-center p-4 bg-blue-50 rounded-lg">
                <i class="fas fa-camera text-blue-500 text-2xl mb-2"></i>
                <h4 class="font-semibold text-blue-900 mb-1">Quality Photos</h4>
                <p class="text-sm text-blue-700">Upload high-resolution images to attract more buyers</p>
            </div>
            
            <div class="text-center p-4 bg-green-50 rounded-lg">
                <i class="fas fa-dollar-sign text-green-500 text-2xl mb-2"></i>
                <h4 class="font-semibold text-green-900 mb-1">Competitive Pricing</h4>
                <p class="text-sm text-green-700">Research market prices for similar properties</p>
            </div>
            
            <div class="text-center p-4 bg-purple-50 rounded-lg">
                <i class="fas fa-clock text-purple-500 text-2xl mb-2"></i>
                <h4 class="font-semibold text-purple-900 mb-1">Quick Response</h4>
                <p class="text-sm text-purple-700">Respond to inquiries within 24 hours</p>
            </div>
        </div>
    </div>
</div>
@endsection
