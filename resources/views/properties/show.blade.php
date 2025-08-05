@extends('layouts.main')

@section('title', $property->title . ' - Real Estate Platform')
@section('description', Str::limit($property->description, 160))

@push('styles')
<!-- Image Gallery Styles -->
<style>
.gallery-main {
    height: 400px;
}
.gallery-thumbs {
    height: 100px;
}
.gallery-thumbs img {
    cursor: pointer;
    opacity: 0.7;
    transition: opacity 0.3s;
}
.gallery-thumbs img.active,
.gallery-thumbs img:hover {
    opacity: 1;
}
</style>
@endpush

@section('content')
<div class="bg-brand-cream min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-gray-600">
                <li><a href="{{ route('home') }}" class="hover:text-brand-dark">Home</a></li>
                <li><i class="fas fa-chevron-right mx-2"></i></li>
                <li><a href="{{ route('home') }}?city={{ $property->city_id }}" class="hover:text-brand-dark">{{ $property->city->name }}</a></li>
                <li><i class="fas fa-chevron-right mx-2"></i></li>
                <li class="text-brand-dark font-medium">{{ Str::limit($property->title, 50) }}</li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Image Gallery -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
                    @if($property->images->count() > 0)
                        <div class="gallery-main relative">
                            <img id="mainImage" src="{{ $property->images->first()->image_url }}" 
                                 alt="{{ $property->title }}" 
                                 class="w-full h-full object-cover">
                            
                            <!-- Image Counter -->
                            <div class="absolute bottom-4 right-4 bg-black bg-opacity-50 text-white px-3 py-1 rounded">
                                <span id="imageCounter">1</span> / {{ $property->images->count() }}
                            </div>
                        </div>
                        
                        @if($property->images->count() > 1)
                            <div class="gallery-thumbs p-4">
                                <div class="flex space-x-2 overflow-x-auto">
                                    @foreach($property->images as $index => $image)
                                        <img src="{{ $image->image_url }}" 
                                             alt="Property image {{ $index + 1 }}"
                                             class="w-24 h-24 object-cover rounded {{ $index === 0 ? 'active' : '' }}"
                                             onclick="changeMainImage('{{ $image->image_url }}', {{ $index + 1 }})">
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="gallery-main bg-gray-200 flex items-center justify-center">
                            <div class="text-center text-gray-500">
                                <i class="fas fa-image text-6xl mb-4"></i>
                                <p>No images available</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Property Details -->
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h1 class="text-3xl font-bold text-brand-dark mb-2">{{ $property->title }}</h1>
                            <div class="flex items-center text-gray-600 mb-4">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                <span>{{ $property->address }}, {{ $property->city->name }}</span>
                            </div>
                        </div>
                        
                        <div class="text-right">
                            <div class="property-price text-3xl mb-2">{{ $property->formatted_price }}</div>
                            <span class="property-status {{ $property->isForSale() ? 'status-sale' : 'status-rent' }}">
                                {{ $property->isForSale() ? 'For Sale' : 'For Rent' }}
                            </span>
                        </div>
                    </div>

                    <!-- Property Features -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8 p-6 bg-brand-cream rounded-lg">
                        @if($property->bedrooms)
                            <div class="text-center">
                                <i class="fas fa-bed text-2xl text-brand-dark mb-2"></i>
                                <div class="font-semibold">{{ $property->bedrooms }}</div>
                                <div class="text-sm text-gray-600">Bedroom{{ $property->bedrooms > 1 ? 's' : '' }}</div>
                            </div>
                        @endif
                        
                        @if($property->bathrooms)
                            <div class="text-center">
                                <i class="fas fa-bath text-2xl text-brand-dark mb-2"></i>
                                <div class="font-semibold">{{ $property->bathrooms }}</div>
                                <div class="text-sm text-gray-600">Bathroom{{ $property->bathrooms > 1 ? 's' : '' }}</div>
                            </div>
                        @endif
                        
                        @if($property->area)
                            <div class="text-center">
                                <i class="fas fa-ruler-combined text-2xl text-brand-dark mb-2"></i>
                                <div class="font-semibold">{{ number_format($property->area) }}</div>
                                <div class="text-sm text-gray-600">m² Area</div>
                            </div>
                        @endif
                        
                        <div class="text-center">
                            <i class="fas fa-tag text-2xl text-brand-dark mb-2"></i>
                            <div class="font-semibold">{{ $property->category->name }}</div>
                            <div class="text-sm text-gray-600">Property Type</div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-brand-dark mb-4">Description</h2>
                        <div class="prose max-w-none text-gray-700">
                            {!! nl2br(e($property->description)) !!}
                        </div>
                    </div>

                    <!-- Additional Features -->
                    @if($property->features && count($property->features) > 0)
                        <div class="mb-8">
                            <h2 class="text-2xl font-bold text-brand-dark mb-4">Features & Amenities</h2>
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

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Contact Owner Card -->
                <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                    <h3 class="text-xl font-bold text-brand-dark mb-4">Contact Property Owner</h3>
                    
                    <!-- Owner Info -->
                    <div class="flex items-center mb-4">
                        <img src="{{ $property->owner->profile_picture_url }}" 
                             alt="{{ $property->owner->name }}" 
                             class="w-12 h-12 rounded-full mr-3">
                        <div>
                            <div class="font-semibold">{{ $property->owner->name }}</div>
                            <div class="text-sm text-gray-600">Property Owner</div>
                        </div>
                    </div>

                    @auth
                        @if(auth()->user()->isClient())
                            <!-- 3-Step Process -->
                            <div class="space-y-3">
                                <a href="{{ route('properties.contact.create', $property) }}" class="btn-primary w-full text-center">
                                    <i class="fas fa-home mr-2"></i>Get Property
                                </a>

                                <div class="text-sm text-gray-600 bg-blue-50 p-3 rounded-lg">
                                    <div class="flex items-start">
                                        <i class="fas fa-info-circle text-blue-500 mt-1 mr-2"></i>
                                        <div>
                                            <p class="font-semibold text-blue-800 mb-1">3-Step Process:</p>
                                            <ol class="list-decimal list-inside text-blue-700 space-y-1">
                                                <li>Contact the property owner</li>
                                                <li>Schedule a property visit</li>
                                                <li>Complete payment (rent/buy)</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <p class="text-gray-600 text-sm mb-4">You must be logged in as a client to contact the owner.</p>
                            <a href="{{ route('login') }}" class="btn-primary w-full text-center">Login as Client</a>
                        @endif
                    @else
                        <p class="text-gray-600 text-sm mb-4">Please login to contact the property owner.</p>
                        <a href="{{ route('login') }}" class="btn-primary w-full text-center">Login</a>
                    @endauth
                </div>

                <!-- Favorite Button -->
                @auth
                    @if(auth()->user()->isClient())
                        @if($isFavorited)
                            <form action="{{ route('client.favorites.destroy', $property) }}" method="POST" class="mb-6">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full btn-secondary">
                                    <i class="fas fa-heart mr-2"></i>
                                    Remove from Favorites
                                </button>
                            </form>
                        @else
                            <form action="{{ route('client.favorites.store', $property) }}" method="POST" class="mb-6">
                                @csrf
                                <button type="submit" class="w-full btn-outline">
                                    <i class="fas fa-heart mr-2"></i>
                                    Add to Favorites
                                </button>
                            </form>
                        @endif
                    @endif
                @endauth

                <!-- Property Stats -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-brand-dark mb-4">Property Information</h3>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Property ID:</span>
                            <span class="font-semibold">#{{ $property->id }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Listed:</span>
                            <span class="font-semibold">{{ $property->published_at->format('M d, Y') }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Category:</span>
                            <span class="font-semibold">{{ $property->category->name }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Location:</span>
                            <span class="font-semibold">{{ $property->city->name }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Similar Properties -->
        @if($similarProperties->count() > 0)
            <div class="mt-16">
                <h2 class="text-3xl font-bold text-brand-dark mb-8 text-center">Similar Properties</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($similarProperties as $similarProperty)
                        @include('partials.property-card', ['property' => $similarProperty])
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function changeMainImage(imageUrl, imageNumber) {
    document.getElementById('mainImage').src = imageUrl;
    document.getElementById('imageCounter').textContent = imageNumber;
    
    // Update active thumbnail
    document.querySelectorAll('.gallery-thumbs img').forEach(img => img.classList.remove('active'));
    event.target.classList.add('active');
}

function contactOwner() {
    alert('Contact owner functionality will be implemented in the next phase!');
}

function requestAppointment() {
    alert('Appointment request functionality will be implemented in the next phase!');
}

function confirmDeal() {
    alert('Deal confirmation functionality will be implemented in the next phase!');
}
</script>
@endpush
@endsection
