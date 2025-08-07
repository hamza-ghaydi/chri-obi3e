@extends('layouts.dashboard')

@section('title', $property->title . ' - Owner Dashboard')
@section('page-title', 'Property Details')

@section('content')
<div class="space-y-8">
    <div class="relative overflow-hidden bg-gradient-to-r from-[#2F2B40] to-[#CBA660] rounded-2xl p-8 text-white shadow-2xl">
        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
        <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-12 -translate-x-12"></div>
        
        <div class="relative z-10">
            <div class="flex justify-between items-start mb-6">
                <div class="flex-1">
                    <h1 class="text-4xl font-bold mb-4">{{ $property->title }}</h1>
                    <div class="flex flex-wrap items-center gap-6 text-white/80">
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-2 text-[#CBA660]"></i>
                            <span>{{ $property->address }}, {{ $property->city->name }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-tag mr-2 text-[#CBA660]"></i>
                            <span>{{ $property->category->name }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-calendar mr-2 text-[#CBA660]"></i>
                            <span>Created {{ $property->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <span class="px-4 py-2 rounded-full text-sm font-semibold backdrop-blur-sm
                        {{ $property->status === 'approved' ? 'bg-green-500/90 text-white' : '' }}
                        {{ $property->status === 'pending' ? 'bg-yellow-500/90 text-white' : '' }}
                        {{ $property->status === 'draft' ? 'bg-gray-500/90 text-white' : '' }}
                        {{ $property->status === 'rejected' ? 'bg-red-500/90 text-white' : '' }}">
                        {{ ucfirst($property->status) }}
                    </span>
                    
                    <div class="text-3xl font-bold bg-white/20 backdrop-blur-sm rounded-xl px-6 py-3">
                        {{ $property->formatted_price }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-8">
            {{-- Property Images --}}
            @if($property->images->count() > 0)
                <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-2xl font-bold text-[#2F2B40] mb-2">Property Photos</h3>
                                <p class="text-gray-600">{{ $property->images->count() }} high-quality images</p>
                            </div>
                            <div class="w-14 h-14 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-xl flex items-center justify-center">
                                <i class="fas fa-camera text-[#CBA660] text-xl"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-8">
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($property->images as $image)
                                <div class="group relative overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                                    <img src="{{ $image->image_url }}" 
                                         alt="{{ $image->alt_text }}" 
                                         class="w-full h-32 object-cover group-hover:scale-110 transition-transform duration-500">
                                    
                                    @if($image->is_featured)
                                        <div class="absolute top-2 left-2 bg-gradient-to-r from-[#CBA660] to-[#CBA660]/80 text-white text-xs px-3 py-1 rounded-full font-semibold backdrop-blur-sm">
                                            <i class="fas fa-star mr-1"></i>Featured
                                        </div>
                                    @endif
                                    
                                    <!-- Overlay on hover -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Property Details -->
            <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold text-[#2F2B40] mb-2">Property Information</h3>
                            <p class="text-gray-600">Detailed specifications and features</p>
                        </div>
                        <div class="w-14 h-14 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-xl flex items-center justify-center">
                            <i class="fas fa-info-circle text-[#CBA660] text-xl"></i>
                        </div>
                    </div>
                </div>
                
                <div class="p-8 space-y-8">
                    <!-- Basic Info Grid -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        @if($property->bedrooms)
                            <div class="group relative bg-gradient-to-br from-[#CBA660]/10 to-[#CBA660]/20 p-6 rounded-2xl border  hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                <div class="text-center">
                                    <div class="w-16 h-16 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-xl flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-bed text-[#CBA660] text-2xl"></i>
                                    </div>
                                    <div class="text-2xl font-bold text-[#2F2B40] mb-1">{{ $property->bedrooms }}</div>
                                    <div class="text-sm text-[#2F2B40]/70 font-medium">Bedroom{{ $property->bedrooms > 1 ? 's' : '' }}</div>
                                </div>
                            </div>
                        @endif
                        
                        @if($property->bathrooms)
                            <div class="group relative bg-gradient-to-br from-[#CBA660]/10 to-[#CBA660]/20 p-6 rounded-2xl border  hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                <div class="text-center">
                                    <div class="w-16 h-16 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-xl flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-bath text-[#CBA660] text-2xl"></i>
                                    </div>
                                    <div class="text-2xl font-bold text-[#2F2B40] mb-1">{{ $property->bathrooms }}</div>
                                    <div class="text-sm text-[#2F2B40]/70 font-medium">Bathroom{{ $property->bathrooms > 1 ? 's' : '' }}</div>
                                </div>
                            </div>
                        @endif
                        
                        @if($property->area)
                            <div class="group relative bg-gradient-to-br from-[#CBA660]/10 to-[#CBA660]/20 p-6 rounded-2xl border  hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                <div class="text-center">
                                    <div class="w-16 h-16 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-xl flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-ruler-combined text-[#CBA660] text-2xl"></i>
                                    </div>
                                    <div class="text-2xl font-bold text-[#2F2B40] mb-1">{{ number_format($property->area) }}</div>
                                    <div class="text-sm text-[#2F2B40]/70 font-medium">m² Area</div>
                                </div>
                            </div>
                        @endif
                        
                        <div class="group relative bg-gradient-to-br from-[#CBA660]/10 to-[#CBA660]/20 p-6 rounded-2xl border hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                            <div class="text-center">
                                <div class="w-16 h-16 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-xl flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-{{ $property->isForSale() ? 'dollar-sign' : 'calendar' }} text-[#CBA660] text-2xl"></i>
                                </div>
                                <div class="text-2xl font-bold text-[#2F2B40] mb-1">{{ $property->isForSale() ? 'Sale' : 'Rent' }}</div>
                                <div class="text-sm text-[#2F2B40]/70 font-medium">Listing Type</div>
                            </div>
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100/50 rounded-2xl p-6 border border-gray-200">
                        <h4 class="text-xl font-bold text-[#2F2B40] mb-4 flex items-center">
                            <i class="fas fa-align-left text-[#CBA660] mr-3"></i>
                            Description
                        </h4>
                        <div class="prose max-w-none text-gray-700 leading-relaxed">
                            {!! nl2br(e($property->description)) !!}
                        </div>
                    </div>

                    {{-- Features --}}
                    @if($property->features && count($property->features) > 0)
                        <div class="bg-gradient-to-br from-[#2F2B40]/5 to-[#CBA660]/5 rounded-2xl p-6 border border-[#CBA660]/20">
                            <h4 class="text-xl font-bold text-[#2F2B40] mb-6 flex items-center">
                                <i class="fas fa-star text-[#CBA660] mr-3"></i>
                                Features & Amenities
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($property->features as $feature)
                                    <div class="flex items-center bg-white/80 backdrop-blur-sm p-3 rounded-xl  hover:shadow-md transition-all duration-300">
                                        <div class="w-8 h-8 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-check text-[#CBA660] text-sm"></i>
                                        </div>
                                        <span class="font-medium text-gray-700">{{ $feature }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Appointments -->
            @if($property->appointments->count() > 0)
                <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-2xl font-bold text-[#2F2B40] mb-2">Recent Appointments</h3>
                                <p class="text-gray-600">Latest viewing requests for this property</p>
                            </div>
                            <a href="{{ route('owner.appointments.index') }}" 
                               class="bg-[#CBA660] text-white px-4 py-2 rounded-lg hover:bg-[#CBA660]/80 transition-all duration-300 text-sm font-medium">
                                View All
                            </a>
                        </div>
                    </div>
                    
                    <div class="p-8">
                        <div class="space-y-4">
                            @foreach($property->appointments->take(5) as $appointment)
                                <div class="group relative bg-gradient-to-r from-gray-50 to-gray-50/50 rounded-xl p-6 border border-gray-100 hover:shadow-lg transition-all duration-300 hover:border-[#CBA660]/30">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <div class="relative">
                                                <img src="{{ $appointment->client->profile_picture_url }}" 
                                                     alt="{{ $appointment->client->name }}" 
                                                     class="w-12 h-12 rounded-full border-2 border-white shadow-lg group-hover:scale-110 transition-transform duration-300">
                                            </div>
                                            <div>
                                                <div class="font-bold text-[#2F2B40] text-lg">{{ $appointment->client->name }}</div>
                                                <div class="text-sm text-gray-600 flex items-center">
                                                    <i class="fas fa-calendar mr-2 text-[#CBA660]"></i>
                                                    {{ $appointment->appointment_date->format('M d, Y - H:i') }}
                                                </div>
                                            </div>
                                        </div>
                                        <span class="px-4 py-2 rounded-full text-sm font-semibold
                                            {{ $appointment->status === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $appointment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $appointment->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-6 py-4 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-[#2F2B40] mb-1">Quick Actions</h3>
                            <p class="text-gray-600 text-sm">Manage this property</p>
                        </div>
                        <i class="fas fa-bolt text-2xl text-[#CBA660]"></i>
                    </div>
                </div>
                
                <div class="p-6 space-y-4">
                    <a href="{{ route('owner.properties.edit', $property) }}" 
                       class="group relative bg-gradient-to-br from-[#CBA660] to-[#CBA660]/80 text-white p-4 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 overflow-hidden block">
                        <div class="absolute top-0 right-0 w-12 h-12 bg-white/10 rounded-full -translate-y-6 translate-x-6"></div>
                        <div class="relative z-10 text-center">
                            <i class="fas fa-edit text-xl mb-2 block"></i>
                            <span class="font-semibold">Edit Property</span>
                        </div>
                    </a>
                    
                    @if($property->status === 'approved' && $property->payment_completed)
                        <a href="{{ route('properties.show', $property) }}" target="_blank"
                           class="group relative bg-white border border-[#CBA660] text-[#CBA660] p-4 rounded-xl hover:bg-[#CBA660]/5 transition-all duration-300 transform hover:scale-105 block">
                            <div class="text-center">
                                <i class="fas fa-external-link-alt text-xl mb-2 block"></i>
                                <span class="font-semibold">View Public Page</span>
                            </div>
                        </a>
                    @endif
                    
                    <form action="{{ route('owner.properties.destroy', $property) }}" method="POST" class="w-full">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="group relative bg-white border border-red-300 text-red-600 p-4 rounded-xl hover:bg-red-50 hover:border-red-400 transition-all duration-300 transform hover:scale-105 w-full"
                                onclick="return confirm('Are you sure you want to delete this property?')">
                            <div class="text-center">
                                <i class="fas fa-trash text-xl mb-2 block"></i>
                                <span class="font-semibold">Delete Property</span>
                            </div>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Payment Status -->
            @if($property->status === 'approved')
                <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-6 py-4 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-[#2F2B40] mb-1">Payment Status</h3>
                                <p class="text-gray-600 text-sm">Listing payment</p>
                            </div>
                            <i class="fas fa-credit-card text-2xl text-[#CBA660]"></i>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        @if($property->payment_completed)
                            <div class="text-center py-6">
                                <div class="w-16 h-16 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-check-circle text-[#CBA660] text-2xl"></i>
                                </div>
                                <p class="text-green-600 font-bold text-lg mb-2">Payment Completed</p>
                                <p class="text-sm text-gray-600">Your property is live and visible to clients!</p>
                            </div>
                        @else
                            <div class="text-center py-6">
                                <div class="w-16 h-16 bg-gradient-to-br from-yellow-500/20 to-yellow-500/40 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-credit-card text-yellow-500 text-2xl"></i>
                                </div>
                                <p class="text-yellow-600 font-bold text-lg mb-2">Payment Required</p>
                                <p class="text-sm text-gray-600 mb-6">Pay the listing fee to publish your property</p>
                                <a href="{{ route('owner.payments.create') }}?property={{ $property->id }}" 
                                   class="bg-gradient-to-r from-[#CBA660] to-[#CBA660]/80 text-white font-semibold px-6 py-3 rounded-xl hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                    <i class="fas fa-credit-card mr-2"></i>Pay Now
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection