@extends('layouts.dashboard')

@section('title', 'My Properties - Owner Dashboard')
@section('page-title', 'My Properties')

@section('breadcrumb')
<a href="{{ route('owner.dashboard') }}" class="hover:text-[#CBA660]">Dashboard</a>
<span class="mx-2">/</span>
<span>My Properties</span>
@endsection

@section('content')
<div class="space-y-8">
    <!-- Header Section with Gradient Background -->
    <div class="relative overflow-hidden bg-gradient-to-r from-[#2F2B40] to-[#CBA660] rounded-2xl p-8 text-white shadow-2xl">
        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
        <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-12 -translate-x-12"></div>
        
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold mb-2">Manage Your Properties</h2>
                <p class="text-white/80 text-lg">Build and manage your real estate portfolio with ChriWBi3</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('owner.properties.create') }}" 
                   class="bg-white text-[#2F2B40] font-semibold px-6 py-3 rounded-xl hover:bg-white/90 transition-all duration-300 transform hover:scale-105 shadow-lg">
                    <i class="fas fa-plus mr-2"></i>Add New Property
                </a>
                
            </div>
        </div>
    </div>


    {{-- Properties Section --}}
    <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        
        <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold text-[#2F2B40] mb-2">Your Properties</h3>
                    <p class="text-gray-600">Manage and track your property listings</p>
                </div>
                <div class="flex space-x-3">
                    <select class="bg-white border border-gray-300 rounded-xl px-7 py-2 text-sm font-medium text-gray-700 hover:border-[#CBA660] focus:border-[#CBA660] focus:ring-2 focus:ring-[#CBA660]/20 transition-all duration-300">
                        <option>All Status</option>
                        <option>Published</option>
                        <option>Pending</option>
                        <option>Draft</option>
                    </select>
                    
                </div>
            </div>
        </div>
        
        @if($properties->count() > 0)
            
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($properties as $property)
                        <div class="group relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-2xl hover:border-[#CBA660]/30 transition-all duration-500 transform hover:scale-105">
                            <!-- Property Image -->
                            <div class="relative overflow-hidden">
                                <img src="{{ $property->featured_image_url }}"
                                     alt="{{ $property->title }}"
                                     class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">

                                <!-- Status Badge -->
                                <div class="absolute top-4 left-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold backdrop-blur-sm
                                        {{ $property->status === 'approved' ? 'bg-green-500/90 text-white' : '' }}
                                        {{ $property->status === 'pending' ? 'bg-yellow-500/90 text-white' : '' }}
                                        {{ $property->status === 'draft' ? 'bg-gray-500/90 text-white' : '' }}
                                        {{ $property->status === 'rejected' ? 'bg-red-500/90 text-white' : '' }}">
                                        {{ ucfirst($property->status) }}
                                    </span>
                                </div>

                                <!-- Listing Type Badge -->
                                <div class="absolute top-4 right-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold backdrop-blur-sm
                                        {{ $property->isForSale() ? 'bg-[#CBA660]/90 text-white' : 'bg-[#2F2B40]/90 text-white' }}">
                                        {{ $property->isForSale() ? 'For Sale' : 'For Rent' }}
                                    </span>
                                </div>

                                <!-- Overlay gradient -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>

                            <!-- Property Details -->
                            <div class="p-6">
                                <!-- Price with gradient text -->
                                <div class="text-2xl font-bold bg-gradient-to-r from-[#2F2B40] to-[#CBA660] bg-clip-text text-transparent mb-3">
                                    {{ $property->formatted_price }}
                                </div>

                                <!-- Title -->
                                <h3 class="text-lg font-semibold text-[#2F2B40] mb-2 line-clamp-2 group-hover:text-[#CBA660] transition-colors duration-300">
                                    {{ $property->title }}
                                </h3>

                                <!-- Location -->
                                <div class="flex items-center text-gray-600 mb-4">
                                    <i class="fas fa-map-marker-alt mr-2 text-[#CBA660]"></i>
                                    <span class="text-sm">{{ $property->city->name }}</span>
                                </div>

                                <!-- Property Features -->
                                <div class="flex items-center justify-between text-sm text-gray-600 mb-6">
                                    @if($property->bedrooms)
                                        <div class="flex items-center bg-gray-50 px-3 py-2 rounded-lg">
                                            <i class="fas fa-bed mr-2 text-[#CBA660]"></i>
                                            <span class="font-medium">{{ $property->bedrooms }}</span>
                                        </div>
                                    @endif

                                    @if($property->bathrooms)
                                        <div class="flex items-center bg-gray-50 px-3 py-2 rounded-lg">
                                            <i class="fas fa-bath mr-2 text-[#CBA660]"></i>
                                            <span class="font-medium">{{ $property->bathrooms }}</span>
                                        </div>
                                    @endif

                                    @if($property->area)
                                        <div class="flex items-center bg-gray-50 px-3 py-2 rounded-lg">
                                            <i class="fas fa-ruler-combined mr-2 text-[#CBA660]"></i>
                                            <span class="font-medium">{{ $property->area }}m²</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-3">
                                    <a href="{{ route('owner.properties.show', $property) }}" 
                                       class="flex-1 bg-white border border-[#CBA660] text-[#CBA660] text-center py-2 px-4 rounded-xl hover:bg-[#CBA660]/5 transition-all duration-300 text-sm font-medium">
                                        <i class="fas fa-eye mr-1"></i>View
                                    </a>

                                    <a href="{{ route('owner.properties.edit', $property) }}" 
                                       class="flex-1 bg-gradient-to-r from-[#CBA660] to-[#CBA660]/80 text-white text-center py-2 px-4 rounded-xl hover:shadow-lg transition-all duration-300 transform hover:scale-105 text-sm font-medium">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </a>

                                    <form action="{{ route('owner.properties.destroy', $property) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-white border border-red-300 text-red-600 hover:bg-red-50 hover:border-red-400 py-2 px-3 rounded-xl transition-all duration-300 text-sm font-medium"
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
                <div class="mt-8 flex justify-center">
                    {{ $properties->links() }}
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="p-8">
                <div class="text-center py-16">
                    <div class="max-w-md mx-auto">
                        <div class="w-24 h-24 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-home text-4xl text-[#CBA660]"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-[#2F2B40] mb-4">No Properties Yet</h3>
                        <p class="text-gray-600 mb-8">Start building your property portfolio by adding your first listing.</p>

                        <div class="space-y-6">
                            <a href="{{ route('owner.properties.create') }}" 
                               class="inline-flex items-center bg-gradient-to-r from-[#CBA660] to-[#CBA660]/80 text-white font-semibold px-8 py-4 rounded-xl hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                <i class="fas fa-plus mr-2"></i>Add Your First Property
                            </a>

                            <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 rounded-xl p-4">
                                <p class="text-sm text-gray-600">
                                    <i class="fas fa-lightbulb text-[#CBA660] mr-2"></i>
                                    <strong>Pro Tip:</strong> High-quality photos and detailed descriptions get 3x more views
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    
</div>
@endsection