@extends('layouts.dashboard')

@section('title', 'My Favorites - Real Estate Platform')
@section('page-title', 'My Favorite Properties')

@section('breadcrumb')
<a href="{{ route('client.dashboard') }}" class="hover:text-brand-dark">Dashboard</a>
<span class="mx-2">/</span>
<span>My Favorites</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex justify-between items-center">
        <div>
            <p class="text-gray-600">{{ $favorites->total() }} favorite properties found</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('home') }}" class="btn-outline">
                <i class="fas fa-search mr-2"></i>Browse More Properties
            </a>
        </div>
    </div>

    @if($favorites->count() > 0)
        <!-- Favorites Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($favorites as $favorite)
                <div class="property-card relative">
                    <!-- Remove from Favorites Button -->
                    <form action="{{ route('client.favorites.destroy', $favorite->property) }}" method="POST" class="absolute top-4 right-4 z-10">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white rounded-full p-2 transition-all duration-200" 
                                onclick="return confirm('Remove this property from favorites?')">
                            <i class="fas fa-heart text-sm"></i>
                        </button>
                    </form>

                    <!-- Property Image -->
                    <div class="relative">
                        <img src="{{ $favorite->property->featured_image_url }}" 
                             alt="{{ $favorite->property->title }}" 
                             class="property-image">
                        
                        <!-- Status Badge -->
                        <div class="absolute top-4 left-4">
                            <span class="property-status {{ $favorite->property->isForSale() ? 'status-sale' : 'status-rent' }}">
                                {{ $favorite->property->isForSale() ? 'For Sale' : 'For Rent' }}
                            </span>
                        </div>
                        
                        <!-- Featured Badge -->
                        @if($favorite->property->is_featured)
                            <div class="absolute bottom-4 left-4">
                                <span class="bg-brand-beige text-brand-dark px-2 py-1 rounded text-xs font-semibold">
                                    <i class="fas fa-star mr-1"></i>Featured
                                </span>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Property Details -->
                    <div class="p-6">
                        <!-- Price -->
                        <div class="flex justify-between items-start mb-3">
                            <div class="property-price">{{ $favorite->property->formatted_price }}</div>
                            @if($favorite->property->area)
                                <div class="text-sm text-gray-500">{{ number_format($favorite->property->area) }} m²</div>
                            @endif
                        </div>
                        
                        <!-- Title -->
                        <h3 class="text-lg font-semibold text-brand-dark mb-2 line-clamp-2">
                            <a href="{{ route('properties.show', $favorite->property) }}" class="hover:text-brand-beige transition-colors duration-200">
                                {{ $favorite->property->title }}
                            </a>
                        </h3>
                        
                        <!-- Location -->
                        <div class="flex items-center text-gray-600 mb-3">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            <span class="text-sm">{{ $favorite->property->city->name }}</span>
                        </div>
                        
                        <!-- Property Features -->
                        <div class="flex items-center justify-between text-sm text-gray-600 mb-4">
                            @if($favorite->property->bedrooms)
                                <div class="flex items-center">
                                    <i class="fas fa-bed mr-1"></i>
                                    <span>{{ $favorite->property->bedrooms }} bed{{ $favorite->property->bedrooms > 1 ? 's' : '' }}</span>
                                </div>
                            @endif
                            
                            @if($favorite->property->bathrooms)
                                <div class="flex items-center">
                                    <i class="fas fa-bath mr-1"></i>
                                    <span>{{ $favorite->property->bathrooms }} bath{{ $favorite->property->bathrooms > 1 ? 's' : '' }}</span>
                                </div>
                            @endif
                            
                            <div class="flex items-center">
                                <i class="fas fa-tag mr-1"></i>
                                <span>{{ $favorite->property->category->name }}</span>
                            </div>
                        </div>
                        
                        <!-- Added Date -->
                        <div class="text-xs text-gray-500 mb-4">
                            <i class="fas fa-heart mr-1"></i>
                            Added {{ $favorite->created_at->diffForHumans() }}
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex gap-2">
                            <a href="{{ route('properties.show', $favorite->property) }}" class="btn-primary flex-1 text-center text-sm py-2">
                                View Details
                            </a>
                            
                            <button onclick="contactOwner({{ $favorite->property->id }})" class="btn-outline flex-1 text-sm py-2">
                                Contact Owner
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-8">
            {{ $favorites->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="max-w-md mx-auto">
                <i class="fas fa-heart text-6xl text-gray-400 mb-6"></i>
                <h3 class="text-2xl font-semibold text-gray-600 mb-4">No Favorite Properties</h3>
                <p class="text-gray-500 mb-8">You haven't added any properties to your favorites yet. Start browsing to find your dream property!</p>
                
                <div class="space-y-4">
                    <a href="{{ route('home') }}" class="btn-primary inline-block">
                        <i class="fas fa-search mr-2"></i>Browse Properties
                    </a>
                    
                    <div class="text-sm text-gray-500">
                        <p>💡 Tip: Click the heart icon on any property to add it to your favorites</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
function contactOwner(propertyId) {
    // This will be implemented when we add the appointment system
    alert('Contact owner functionality will be available soon!');
}
</script>
@endpush
@endsection
