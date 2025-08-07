@extends('layouts.main')

@section('title', $property->title . ' - Real Estate Platform')
@section('description', Str::limit($property->description, 160))

@push('styles')
    <!-- Image Gallery Styles -->
    <style>
        .gallery-main {
            height: 500px;
        }

        .gallery-thumbs {
            height: 120px;
        }

        .gallery-thumbs img {
            cursor: pointer;
            opacity: 0.7;
            transition: all 0.3s ease;
            border: 3px solid transparent;
        }

        .gallery-thumbs img.active,
        .gallery-thumbs img:hover {
            opacity: 1;
            border-color: #CBA660;
            transform: scale(1.05);
        }
    </style>
@endpush

@section('content')
    <div class="min-h-screen py-8" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-8">
                    {{-- Image Gallery  --}}
                    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-100">
                        @if ($property->images->count() > 0)
                            <div class="gallery-main relative overflow-hidden">
                                <img id="mainImage" src="{{ $property->images->first()->image_url }}"
                                    alt="{{ $property->title }}"
                                    class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">

                               
                                <div
                                    class="absolute bottom-6 right-6 bg-[#2F2B40]/90 backdrop-blur-sm text-white px-4 py-2 rounded-xl shadow-lg">
                                    <span id="imageCounter" class="font-semibold">1</span>
                                    <span class="text-[#CBA660]">/</span>
                                    <span class="font-semibold">{{ $property->images->count() }}</span>
                                </div>

                               
                                <div class="absolute top-6 right-6">
                                    <span
                                        class="px-4 py-2 rounded-xl text-sm font-semibold backdrop-blur-sm shadow-lg
                                    {{ $property->isForSale() ? 'bg-[#CBA660]/90 text-white' : 'bg-[#2F2B40]/90 text-white' }}">
                                        {{ $property->isForSale() ? 'For Sale' : 'For Rent' }}
                                    </span>
                                </div>
                            </div>

                            @if ($property->images->count() > 1)
                                <div class="gallery-thumbs p-6 bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5">
                                    <div class="flex space-x-3 overflow-x-auto pb-2">
                                        @foreach ($property->images as $index => $image)
                                            <img src="{{ $image->image_url }}" alt="Property image {{ $index + 1 }}"
                                                class="w-28 h-28 object-cover rounded-xl flex-shrink-0 {{ $index === 0 ? 'active' : '' }}"
                                                onclick="changeMainImage('{{ $image->image_url }}', {{ $index + 1 }})">
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @else
                            <div
                                class="gallery-main bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                <div class="text-center text-gray-500">
                                    <div
                                        class="w-24 h-24 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-full flex items-center justify-center mx-auto mb-6">
                                        <i class="fas fa-image text-4xl text-[#CBA660]"></i>
                                    </div>
                                    <p class="text-lg font-medium">No images available</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{--  Property Details --}}
                    <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden">
                        
                        <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 p-8 border-b border-gray-100">
                            <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start">
                                <div class="mb-6 lg:mb-0">
                                    <h1 class="text-4xl font-bold text-[#2F2B40] mb-4">{{ $property->title }}</h1>
                                    <div class="flex items-center text-gray-600 mb-2">
                                        <i class="fas fa-map-marker-alt mr-3 text-[#CBA660]"></i>
                                        <span class="text-lg">{{ $property->address }}, {{ $property->city->name }}</span>
                                    </div>
                                </div>

                                <div class="text-center lg:text-right">
                                    <div
                                        class="text-4xl font-bold text-[#CBA660] mb-3">
                                        {{ $property->formatted_price }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-8">
                            {{-- Property Features --}}
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12">
                                @if ($property->bedrooms)
                                    <div class="text-center group">
                                        <div
                                            class="w-16 h-16 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:shadow-lg transition-all duration-300">
                                            <i class="fas fa-bed text-2xl text-[#CBA660]"></i>
                                        </div>
                                        <div class="text-2xl font-bold text-[#2F2B40]">{{ $property->bedrooms }}</div>
                                        <div class="text-sm text-gray-600 font-medium">
                                            Bedroom{{ $property->bedrooms > 1 ? 's' : '' }}</div>
                                    </div>
                                @endif

                                @if ($property->bathrooms)
                                    <div class="text-center group">
                                        <div
                                            class="w-16 h-16 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:shadow-lg transition-all duration-300">
                                            <i class="fas fa-bath text-2xl text-[#CBA660]"></i>
                                        </div>
                                        <div class="text-2xl font-bold text-[#2F2B40]">{{ $property->bathrooms }}</div>
                                        <div class="text-sm text-gray-600 font-medium">
                                            Bathroom{{ $property->bathrooms > 1 ? 's' : '' }}</div>
                                    </div>
                                @endif

                                @if ($property->area)
                                    <div class="text-center group">
                                        <div
                                            class="w-16 h-16 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:shadow-lg transition-all duration-300">
                                            <i class="fas fa-ruler-combined text-2xl text-[#CBA660]"></i>
                                        </div>
                                        <div class="text-2xl font-bold text-[#2F2B40]">{{ number_format($property->area) }}
                                        </div>
                                        <div class="text-sm text-gray-600 font-medium">m² Area</div>
                                    </div>
                                @endif

                                <div class="text-center group">
                                    <div
                                        class="w-16 h-16 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:shadow-lg transition-all duration-300">
                                        <i class="fas fa-tag text-2xl text-[#CBA660]"></i>
                                    </div>
                                    <div class="text-2xl font-bold text-[#2F2B40]">{{ $property->category->name }}</div>
                                    <div class="text-sm text-gray-600 font-medium">Property Type</div>
                                </div>
                            </div>

                            
                            <div class="mb-12">
                                <h2 class="text-3xl font-bold text-[#2F2B40] mb-6 flex items-center">
                                    <div class="w-1 h-8 bg-gradient-to-b from-[#CBA660] to-[#CBA660]/60 rounded-full mr-4">
                                    </div>
                                    Description
                                </h2>
                                <div
                                    class="prose max-w-none text-gray-700 text-lg leading-relaxed bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 p-6 rounded-xl">
                                    {!! nl2br(e($property->description)) !!}
                                </div>
                            </div>

                            {{-- Features --}}
                            @if ($property->features && count($property->features) > 0)
                                <div class="mb-8">
                                    <h2 class="text-3xl font-bold text-[#2F2B40] mb-6 flex items-center">
                                        <div
                                            class="w-1 h-8 bg-gradient-to-b from-[#CBA660] to-[#CBA660]/60 rounded-full mr-4">
                                        </div>
                                        Features & Amenities
                                    </h2>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @foreach ($property->features as $feature)
                                            <div
                                                class="flex items-center  p-3 rounded-xl border border-[#CBA660]/50 ">
                                                <ul class="list-item">
                                                    <li class="font-medium text-gray-800">{{ $feature }}</li>
                                                </ul>
                                                
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="lg:col-span-1 space-y-8">
                    <!-- Contact Owner Card -->
                    <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-[#2F2B40] to-[#CBA660] p-6 text-white">
                            <h3 class="text-2xl font-bold mb-2">Contact Property Owner</h3>
                            <p class="text-white/80">Get in touch with the property owner</p>
                        </div>

                        <div class="p-6">
                            <!-- Owner Info -->
                            <div
                                class="flex items-center mb-6 p-4 bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 rounded-xl">
                                    
                                <div>
                                    <div class="text-lg font-bold text-[#2F2B40]">{{ $property->owner->name }}</div>
                                    <div class="text-sm text-gray-600 font-medium">Property Owner</div>
                                </div>
                            </div>

                            @auth
                                @if (auth()->user()->isClient())
                                    <!-- 3-Step Process -->
                                    <div class="space-y-4">
                                        <a href="{{ route('properties.contact.create', $property) }}"
                                            class="w-full bg-gradient-to-r from-[#CBA660] to-[#CBA660]/80 text-white font-semibold py-4 px-6 rounded-xl hover:shadow-lg transition-all duration-300 transform hover:scale-105 text-center flex items-center justify-center">
                                            <i class="fas fa-home mr-2"></i>Get Property
                                        </a>

                                        <div
                                            class="">
                                            <div class="flex items-start">
                                                
                                                <div>
                                                    <p class="font-bold text-xl text-[#CBA660] mb-2">3-Step Process:</p>
                                                    <ol class="list-decimal list-inside text-[#2F2B40] space-y-1">
                                                        <li>Contact the property owner</li>
                                                        <li>Schedule a property visit</li>
                                                        <li>Continue with Owner</li>
                                                    </ol>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center">
                                        <p class="text-gray-600 mb-4">You must be logged in as a client to contact the owner.
                                        </p>
                                        <a href="{{ route('login') }}"
                                            class="w-full bg-gradient-to-r from-[#CBA660] to-[#CBA660]/80 text-white font-semibold py-3 px-6 rounded-xl hover:shadow-lg transition-all duration-300 transform hover:scale-105 text-center inline-block">
                                            Login as Client
                                        </a>
                                    </div>
                                @endif
                            @else
                                <div class="text-center">
                                    <p class="text-gray-600 mb-4">Please login to contact the property owner.</p>
                                    <a href="{{ route('login') }}"
                                        class="w-full bg-gradient-to-r from-[#CBA660] to-[#CBA660]/80 text-white font-semibold py-3 px-6 rounded-xl hover:shadow-lg transition-all duration-300 transform hover:scale-105 text-center inline-block">
                                        Login
                                    </a>
                                </div>
                            @endauth
                        </div>
                    </div>

                    <!-- Favorite Button -->
                    @auth
                        @if (auth()->user()->isClient())
                            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                                @if ($isFavorited)
                                    <form action="{{ route('client.favorites.destroy', $property) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-full bg-gradient-to-r from-red-500 to-red-400 text-white font-semibold py-3 px-6 rounded-xl hover:shadow-lg transition-all duration-300 transform hover:scale-105 flex items-center justify-center">
                                            <i class="fas fa-heart mr-2"></i>
                                            Remove from Favorites
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('client.favorites.store', $property) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="w-full bg-white border-2 border-[#CBA660] text-[#CBA660] font-semibold py-3 px-6 rounded-xl hover:bg-[#CBA660] hover:text-white transition-all duration-300 transform hover:scale-105 flex items-center justify-center">
                                            <i class="fas fa-heart mr-2"></i>
                                            Add to Favorites
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endif
                    @endauth

                    <!-- Property Stats -->
                    <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-[#2F2B40]/10 to-[#CBA660]/10 p-6 border-b border-gray-100">
                            <h3 class="text-2xl font-bold text-[#2F2B40]">Property Information</h3>
                        </div>

                        <div class="p-6 space-y-4">
                        
                            <div
                                class="flex justify-between items-center p-3 bg-gradient-to-r from-gray-50 to-gray-50/50 rounded-xl">
                                <span class="text-gray-600 font-medium">Category:</span>
                                <span class="font-bold text-[#2F2B40]">{{ $property->category->name }}</span>
                            </div>

                            <div
                                class="flex justify-between items-center p-3 bg-gradient-to-r from-gray-50 to-gray-50/50 rounded-xl">
                                <span class="text-gray-600 font-medium">Location:</span>
                                <span class="font-bold text-[#2F2B40]">{{ $property->city->name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
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
