@extends('layouts.main')


@section('content')
    {{-- hero section --}}
    <section
        class="relative bg-[url('https://img-v2.gtsstatic.net/reno/imagereader.aspx?url=https%3A%2F%2Fm.sothebysrealty.com%2F1103i215%2Ffavt15r0j5njmhjdvcg88eepk1i215&w=3840&q=75&option=N&permitphotoenlargement=false&fallbackimageurl=https://www.sothebysrealty.com/resources/siteresources/commonresources/images/nophoto/no_image_new.png')] h-screen w-full bg-no-repeat bg-cover">
        <div class="space-y-4 absolute bg-black/70 w-full h-full flex flex-col items-center justify-center">
            <h1 class="text-white text-4xl font-bold">Welcome to ChriWBi3 – <span class="text-[#CBA660]">Your Trusted Real
                    Estate Partner</span></h1>
            <p class="text-white/80 text-xl">Buy, Sell, or Rent properties with confidence.</p>
            <p class="text-white/80 text-xl">Find your dream home or list your property in just a few clicks.</p>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="bg-[#2F2B40] rounded-lg shadow-lg p-6">
                    <form action="{{ route('home') }}" method="GET" class="grid grid-cols-1 md:grid-cols-6 gap-4">
                        <div class="flex flex-col space-y-2">
                            <label class="form-label text-white">Search</label>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search properties..."
                                class="m-1 bg-transparent border rounded-md text-[#CBA660] focus:border-[#CBA660] outline-none">
                        </div>

                        <div class="flex flex-col space-y-2">
                            <label class="form-label text-white">Type</label>
                            <select name="status"
                                class="m-1 bg-transparent border rounded-md text-[#CBA660] focus:border-[#CBA660] outline-none">
                                <option value="">All Types</option>
                                <option value="sale" {{ request('status') == 'sale' ? 'selected' : '' }}>For Sale
                                </option>
                                <option value="rent" {{ request('status') == 'rent' ? 'selected' : '' }}>For Rent
                                </option>
                            </select>
                        </div>

                        <div class="flex flex-col space-y-2">
                            <label class="form-label text-white">Category</label>
                            <select name="category"
                                class="m-1 bg-transparent border rounded-md text-[#CBA660] focus:border-[#CBA660] outline-none">
                                <option value="" selected>All Categories</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex flex-col space-y-2">
                            <label class="form-label text-white">City</label>
                            <select name="city"
                                class="m-1 bg-transparent border rounded-md text-[#CBA660] focus:border-[#CBA660] outline-none">
                                <option value="">All Cities</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}"
                                        {{ request('city') == $city->id ? 'selected' : '' }}>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex flex-col space-y-2">
                            <label class="form-label text-white">Min Price</label>
                            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min"
                                class="m-1 bg-transparent border rounded-md text-[#CBA660] focus:border-[#CBA660] outline-none">
                        </div>

                        <button type="submit"
                            class="text-white text-xl font-bold bg-[#CBA660] m-auto px-8 py-2 rounded-lg mt-8">
                            Filter
                        </button>
                    </form>
                </div>


            </div>
        </div>




    </section>

    {{-- about us --}}

    <section class="" id="about-us">
        <div class="container mx-auto px-4 py-8">
            <div class="px-4 sm:px-6 lg:px-8 w-full">

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

                    <div class="relative">

                        <div
                            class="relative z-10 rounded-2xl overflow-hidden shadow-2xl transform rotate-2 hover:rotate-0 transition-transform duration-500 border-2 border-[#CBA660]/30">
                            <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80"
                                alt="" class="w-full object-cover">

                        </div>


                        <div
                            class="absolute -top-4 -right-4 z-20 rounded-xl overflow-hidden shadow-xl transform -rotate-3 hover:rotate-0 transition-transform duration-500 border-2 border-[#CBA660]/50">
                            <img src="https://images.unsplash.com/photo-1564013799919-ab600027ffc6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80"
                                class="w-48 object-cover">

                        </div>


                        <div
                            class="absolute -bottom-6 -left-6 z-20 rounded-xl overflow-hidden shadow-xl transform rotate-6 hover:rotate-0 transition-transform duration-500 border-2 border-[#CBA660]/50">
                            <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80"
                                class="w-40 h-28 object-cover">

                        </div>


                        <div class="absolute top-10 left-10 w-20 h-20 bg-[#CBA660]/30 rounded-full blur-xl"></div>
                        <div class="absolute bottom-20 right-10 w-16 h-16 bg-[#2F2B40]/40 rounded-full blur-xl"></div>
                    </div>


                    <div class=" space-y-3 py-7">

                        <div
                            class="inline-flex items-center px-6 py-3 bg-[#cba660]/80 backdrop-blur-sm rounded-full border border-[#CBA660]/30">
                            <span class="text-white text-sm font-bold uppercase tracking-wide">
                                Why Choose ChriWBi3 Real Estate
                            </span>
                        </div>


                        <div>
                            <h2 class="text-3xl font-bold text-[#2F2B40] mb-4">
                                Real estate professionals in
                                <span class="text-[#CBA660]">Morocco</span>
                                offer you the best <span class="text-[#CBA660]">services</span>
                            </h2>
                        </div>


                        <div class="text-black/60 text-xl space-y-4">
                            <p>
                                <strong class="text-[#CBA660]">ChriWBi3</strong> is a premier real estate agency in
                                <strong class="text-[#CBA660]">Morocco</strong> that accompanies you in all stages of
                                searching
                                for real estate for sale or rent. We are committed to:
                            </p>
                        </div>


                        <div class="space-y-4">
                            <div class="flex items-centre space-x-4 p-2 rounded-lg border border-[#CBA660]/20">
                                <div class="w-4 h-4 bg-[#CBA660] rounded-full flex items-center justify-center">

                                </div>
                                <div class="text-white/90">
                                    <strong class="text-[#CBA660]">Providing a complete and personalized service</strong>
                                </div>
                            </div>

                            <div class="flex items-centre space-x-4 p-2 rounded-lg border border-[#CBA660]/20">
                                <div class="w-4 h-4 bg-[#CBA660] rounded-full flex items-center justify-center">

                                </div>
                                <div class="text-white/90">
                                    <strong class="text-[#CBA660]">Providing you with quality photos and clear
                                        listings</strong>
                                </div>
                            </div>

                            <div class="flex items-centre space-x-4 p-2 rounded-lg border border-[#CBA660]/20">
                                <div class="w-4 h-4 bg-[#CBA660] rounded-full flex items-center justify-center">

                                </div>
                                <div class="text-white/90">
                                    <strong class="text-[#CBA660]">Advising you in decision-making</strong>
                                </div>
                            </div>

                            <div class="flex items-centre space-x-4 p-2 rounded-lg border border-[#CBA660]/20">
                                <div class="w-4 h-4 bg-[#CBA660] rounded-full flex items-center justify-center">

                                </div>
                                <div class="text-white/90">
                                    <strong class="text-[#CBA660]">Ensuring professional and high-quality follow up</strong>
                                </div>
                            </div>
                        </div>

                        <!-- CTA Button -->
                        <div class="pt-6">
                            <button
                                class="group inline-flex items-center px-8 py-4 bg-[#CBA660] text-[#2F2B40] font-bold text-xl rounded-lg hover:bg-[#CBA660]/90 ">
                                <span>Learn More About ChriWBi3</span>
                                <i
                                    class="fas fa-arrow-right ml-3 group-hover:translate-x-1 transition-transform duration-300"></i>
                            </button>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- properties --}}

    <section class="py-16 bg-white" id="properties">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <div
                    class="inline-flex items-center px-10 py-3 bg-[#cba660]/80 backdrop-blur-sm rounded-full border border-[#CBA660]/30">
                    <span class="text-white text-sm font-bold uppercase tracking-wide">
                        Featured Properties
                    </span>
                </div>

            </div>
            {{-- card property --}}
            @if ($properties->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($properties as $property)
                        <div
                            class="property-card bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                            {{-- Property Image with Navigation  --}}
                            <div class="relative h-64">
                                @if ($property->images->count() > 0)
                                    <img src="{{ $property->featured_image_url }}"
                                        alt="{{ $property->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                                        <i class="fas fa-home text-3xl text-gray-500"></i>
                                    </div>
                                @endif

                                {{-- Status Badge --}}
                                <div class="absolute top-3 left-3">
                                    <span
                                        class="bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wide">
                                        {{ $property->status == 'sale' ? 'For Sale' : 'For Rent' }}
                                    </span>
                                </div>

                                {{-- Favorite Button --}}
                                @auth
                                    @if (auth()->user()->isClient())
                                        @php $isFavorited = auth()->user()->favorites->contains($property->id); @endphp
                                        @if ($isFavorited)
                                            <form action="{{ route('client.favorites.destroy', $property) }}" method="POST"
                                                class="absolute bottom-3 right-3">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-white bg-opacity-80 hover:bg-opacity-100 rounded-full p-2 transition-all duration-200">
                                                    <i class="fas fa-heart text-red-500"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('client.favorites.store', $property) }}" method="POST"
                                                class="absolute bottom-3 right-3">
                                                @csrf
                                                <button type="submit"
                                                    class="bg-white bg-opacity-80 hover:bg-opacity-100 rounded-full p-2 transition-all duration-200">
                                                    <i class="fas fa-heart text-[#CBA660]"></i>
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                @endauth

                                {{-- Location Badge --}}
                                <div class="absolute bottom-3 left-3">
                                    <div
                                        class="bg-black bg-opacity-60 text-white px-2 py-1 rounded text-xs flex items-center">
                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                        <span>{{ $property->city->name ?? '' }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Property Details --}}
                            <div class="p-4">
                                <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2 leading-tight">
                                    <a href="{{ route('properties.show', $property) }}"
                                        class="hover:text-[#2F2B40] transition-colors duration-200">
                                        {{ $property->title }}
                                    </a>
                                </h3>

                                {{-- Price --}}
                                <div class="text-xl font-bold text-[#CBA660] mb-3">
                                    {{ number_format($property->price) }} MAD
                                </div>

                                {{-- Description Preview --}}
                                @if ($property->description)
                                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                                        {{ Str::limit($property->description, 100) }}
                                    </p>
                                @endif

                                {{-- Property Features --}}
                                <div class="flex items-center justify-between text-sm text-gray-500 mb-4 border-t pt-3">
                                    @if ($property->bedrooms)
                                        <div class="flex items-center">
                                            <i class="fas fa-bed mr-1 text-[#CBA660]"></i>
                                            <span>{{ $property->bedrooms }}</span>
                                        </div>
                                    @endif

                                    @if ($property->bathrooms)
                                        <div class="flex items-center">
                                            <i class="fas fa-bath mr-1 text-[#CBA660]"></i>
                                            <span>{{ $property->bathrooms }}</span>
                                        </div>
                                    @endif

                                    @if ($property->area)
                                        <div class="flex items-center">
                                            <i class="fas fa-expand-arrows-alt mr-1 text-[#CBA660]"></i>
                                            <span>{{ number_format($property->area) }} m²</span>
                                        </div>
                                    @endif

                                    <div class="flex items-center">
                                        <i class="fas fa-tag mr-1 text-[#CBA660]"></i>
                                        <span>{{ $property->category->name }}</span>
                                    </div>
                                </div>

                                {{-- Agent Info --}}
                                <div class="flex items-center justify-between border-t pt-3">
                                    <div class="flex items-center">
                                        @if ($property->owner && $property->owner->avatar)
                                            <img src="{{ $property->owner->avatar }}" alt="{{ $property->owner->name }}"
                                                class="w-8 h-8 rounded-full mr-2 object-cover">
                                        @else
                                            <div
                                                class="w-8 h-8 rounded-full bg-gray-300 mr-2 flex items-center justify-center">
                                                <i class="fas fa-user text-gray-500 text-xs"></i>
                                            </div>
                                        @endif
                                        <span class="text-sm font-medium text-gray-700">
                                            {{ $property->owner->name ?? 'Agent Name' }}
                                        </span>
                                    </div>

                                    
                                </div>

                                {{-- Details Button --}}
                                <div class="mt-3">
                                    <a href="{{ route('properties.show', $property) }}"
                                        class="w-full bg-[#2F2B40] hover:bg-[#CBA660] text-white text-center py-2 px-4 rounded-md transition-colors duration-200 text-sm font-medium inline-block">
                                        détails
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12 flex justify-center">
                    {{ $properties->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <i class="fas fa-home text-6xl text-gray-400 mb-6"></i>
                    <h3 class="text-2xl font-semibold text-gray-600 mb-4">No Properties Found</h3>
                    <p class="text-gray-500 mb-6">Try adjusting your search criteria or browse all properties.</p>
                    <a href="{{ route('home') }}"
                        class="inline-block px-8 py-3 text-white font-semibold rounded-md transition-all duration-300 hover:opacity-90"
                        style="background-color: #CBA660;">
                        View All Properties
                    </a>
                </div>
            @endif

        </div>
    </section>

    {{-- Property Listing --}}
    <section id="list-property"
        class="relative bg-[url('https://argonaut.au.reastatic.net/resi-property/prod/homepage-web/web_sml-4ee24fa4ad9acc5ce8d5.jpg')] bg-no-repeat bg-cover">
        <div class="ablolute w-full h-full flex items-center justify-center flex-col bg-black/50 py-10 px-10 space-y-6">

            <div class="inline-flex items-center px-10 py-3  rounded-full border border-[#CBA660]/30">
                <span class="text-white text-xl font-bold uppercase tracking-wide">
                    Own a property?
                </span>
            </div>


            <p class="text-xl md:text-2xl text-white mb-8 font-medium">
                List it on <span class="text-[#CBA660] font-bold">ChriWBi3</span> in just minutes.
            </p>

            {{-- Features Grid --}}
            <div class="grid md:grid-cols-3 gap-6 mb-10">

                <div class="bg-[#2F2B40]/60 rounded-lg p-6 shadow-md hover:shadow-lg transition-shadow duration-300">
                    <h3 class="text-lg font-semibold text-white mb-2">Low Commission</h3>
                    <p class="text-white">Pay only <span class="font-bold text-yellow-500">5%</span> of your listing
                        price.</p>
                </div>


                <div class="bg-[#2F2B40]/60 rounded-lg p-6 shadow-md hover:shadow-lg transition-shadow duration-300">

                    <h3 class="text-lg font-semibold text-white mb-2">Easy Management</h3>
                    <p class="text-white">Manage appointments easily with our intuitive system.</p>
                </div>


                <div class="bg-[#2F2B40]/60 rounded-lg p-6 shadow-md hover:shadow-lg transition-shadow duration-300">

                    <h3 class="text-lg font-semibold text-white mb-2">Direct Connection</h3>
                    <p class="text-white">Connect directly with interested clients instantly.</p>
                </div>
            </div>

            {{-- Call to Action Button --}}
            <div class="space-y-4">
                @auth
                    @if (auth()->user()->isOwner())
                        <a href="{{ route('owner.properties.create') }}"
                            class="inline-flex items-center bg-[#CBA660] text-white font-semibold py-4 px-8 rounded-full text-lg transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            Start Listing Now
                        </a>
                    @else
                        <a href="{{ route('register') }}"
                            class="inline-flex items-center bg-[#CBA660] text-white font-semibold py-4 px-8 rounded-full text-lg transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            Start Listing Now
                        </a>
                    @endif
                @else
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center bg-[#CBA660] text-white font-semibold py-4 px-8 rounded-full text-lg transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        Start Listing Now
                    </a>
                @endauth


                <p class="text-sm text-white/80 mt-4">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-[#CBA660]  font-medium">Sign in here</a>
                </p>
            </div>
        </div>
    </section>
@endsection
