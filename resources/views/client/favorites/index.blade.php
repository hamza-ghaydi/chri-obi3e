@extends('layouts.dashboard')

@section('title', 'My Favorites - Real Estate Platform')
@section('page-title', 'My Favorite Properties')

@section('content')
    <div class="space-y-8">


        <div
            class="relative overflow-hidden bg-gradient-to-r from-[#2F2B40] to-[#CBA660] rounded-2xl p-8 text-white shadow-2xl">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-12 -translate-x-12"></div>

            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold mb-2">My Favorite Properties</h2>
                    <p class="text-white/80 text-lg">{{ $favorites->total() }} properties saved for later</p>
                </div>
                <div class="hidden md:block">
                    <i class="fas fa-heart text-6xl text-[#CBA660]/30"></i>
                </div>
            </div>
        </div>

        <div class="flex justify-between items-center bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
            <div class="flex items-center space-x-4">
                <div
                    class="w-12 h-12 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-xl flex items-center justify-center">
                    <i class="fas fa-filter text-[#CBA660] text-lg"></i>
                </div>
                <div>
                    <p class="font-semibold text-[#2F2B40] text-lg">{{ $favorites->total() }} favorite properties found</p>
                    <p class="text-gray-600 text-sm">Your saved properties collection</p>
                </div>
            </div>

            <a href="{{ route('home') }}"
                class="bg-gradient-to-r from-[#CBA660] to-[#CBA660]/80 text-white px-6 py-3 rounded-xl font-medium hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-search mr-2"></i>Browse More Properties
            </a>
        </div>

        @if ($favorites->count() > 0)

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach ($favorites as $favorite)
                    <div
                        class="group relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:scale-105">


                        <form action="{{ route('client.favorites.destroy', $favorite->property) }}" method="POST"
                            class="absolute top-4 right-4 z-20">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-[#CBA660] w-10 h-10 flex items-center justify-center text-white rounded-full p-3 transition-all duration-300 transform hover:scale-110 shadow-lg backdrop-blur-sm"
                                onclick="return confirm('are you sure about that')">
                                <i class="fas fa-heart text-sm"></i>
                            </button>
                        </form>


                        <div class="">
                            <img src="{{ $favorite->property->featured_image_url }}" alt="{{ $favorite->property->title }}"
                                class="w-full h-48 object-cover ">

                            <div class="absolute top-4 left-4">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-semibold shadow-lg backdrop-blur-sm
                                {{ $favorite->property->isForSale() ? 'bg-[#CBA660] text-white' : 'bg-[#CBA660] text-white' }}">
                                    {{ $favorite->property->isForSale() ? 'For Sale' : 'For Rent' }}
                                </span>
                            </div>

                        </div>

                        {{-- Property Details --}}
                        <div class="p-6">

                            <div class="flex justify-between items-start mb-4">
                                <div class="text-2xl font-bold text-[#CBA660]">{{ $favorite->property->formatted_price }}
                                </div>
                                @if ($favorite->property->area)
                                    <div class="bg-gray-100 px-3 py-1 rounded-full text-sm text-gray-600 font-medium">
                                        {{ number_format($favorite->property->area) }} m²
                                    </div>
                                @endif
                            </div>


                            <h3 class="text-lg font-bold text-[#2F2B40] mb-3 line-clamp-2 min-h-[3.5rem]">
                                <a href="{{ route('properties.show', $favorite->property) }}"
                                    class="hover:text-[#CBA660] transition-colors duration-200">
                                    {{ $favorite->property->title }}
                                </a>
                            </h3>


                            <div
                                class="flex items-center justify-between text-sm text-gray-600 mb-4 bg-gray-50 p-3 rounded-xl">
                                @if ($favorite->property->bedrooms)
                                    <div class="flex items-center">
                                        <i class="fas fa-bed mr-2 text-[#CBA660]"></i>
                                        <span class="font-medium">{{ $favorite->property->bedrooms }}</span>
                                    </div>
                                @endif

                                @if ($favorite->property->bathrooms)
                                    <div class="flex items-center">
                                        <i class="fas fa-bath mr-2 text-[#CBA660]"></i>
                                        <span class="font-medium">{{ $favorite->property->bathrooms }}</span>
                                    </div>
                                @endif

                                <div class="flex items-center">
                                    <i class="fas fa-tag mr-2 text-[#CBA660]"></i>
                                    <span class="font-medium text-xs">{{ $favorite->property->category->name }}</span>
                                </div>
                            </div>


                            <div class="flex items-center text-gray-600 mb-4">
                                <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-map-marker-alt text-sm text-gray-500"></i>
                                </div>
                                <span class="text-sm font-medium">{{ $favorite->property->city->name }}</span>
                            </div>



                            <!-- Action Buttons -->
                            <div class="flex gap-3">
                                <a href="{{ route('properties.show', $favorite->property) }}"
                                    class="flex-1 bg-gradient-to-r from-[#CBA660] to-[#CBA660]/80 text-white py-3 rounded-xl text-center font-medium hover:shadow-lg transition-all duration-300 transform hover:scale-105 text-sm">
                                    View Details
                                </a>

                                <button onclick="contactOwner({{ $favorite->property->id }})"
                                    class="flex-1 bg-white border border-[#CBA660] text-[#CBA660] py-3 rounded-xl font-medium hover:bg-[#CBA660]/5 transition-all duration-300 transform hover:scale-105 text-sm">
                                    Contact Owner
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="text-center py-20">
                    <div class="max-w-md mx-auto">
                        <!-- Animated Heart Icon -->
                        <div class="relative mb-8">
                            <div
                                class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto">
                                <i class="fas fa-heart text-4xl text-gray-400"></i>
                            </div>

                        </div>

                        <h3 class="text-3xl font-bold text-[#2F2B40] mb-4">No Favorite Properties</h3>
                        <p class="text-gray-500 text-lg mb-8 leading-relaxed">
                            You haven't added any properties to your favorites yet.<br>
                            Start browsing to find your dream property!
                        </p>

                        <div class="space-y-6">
                            <a href="{{ route('home') }}"
                                class="inline-flex items-center bg-gradient-to-r from-[#CBA660] to-[#CBA660]/80 text-white font-semibold px-8 py-4 rounded-xl hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                <i class="fas fa-search mr-3"></i>Browse Properties
                            </a>


                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
