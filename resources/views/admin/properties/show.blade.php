@extends('layouts.dashboard')

@section('title', 'Review Property - ChriWBi3 Real Estate Platform')
@section('page-title', 'Property Review')



@section('content')
    <div class="space-y-8">
        <!-- Property Header -->
        <div
            class="relative overflow-hidden bg-gradient-to-r from-[#2F2B40] to-[#CBA660] rounded-2xl p-8 text-white shadow-2xl">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-12 -translate-x-12"></div>

            <div class="relative z-10">
                <div class="flex justify-between items-start mb-6">
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold mb-4">{{ $property->title }}</h1>
                        <div class="flex flex-wrap items-center gap-6 text-white/90">
                            <span class="flex items-center">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                {{ $property->address }}, {{ $property->city->name }}
                            </span>
                            <span class="flex items-center">
                                <i class="fas fa-tag mr-2"></i>
                                {{ $property->category->name }}
                            </span>
                            <span class="flex items-center">
                                <i class="fas fa-calendar mr-2"></i>
                                Submitted {{ $property->created_at->format('M d, Y') }}
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4 ml-6">
                        <span
                            class="px-4 py-2 rounded-full text-sm font-semibold bg-white/20 backdrop-blur-sm
                        {{ $property->status === 'approved' ? 'bg-green-500/20 text-green-100' : '' }}
                        {{ $property->status === 'pending' ? 'bg-yellow-500/20 text-yellow-100' : '' }}
                        {{ $property->status === 'draft' ? 'bg-gray-500/20 text-gray-100' : '' }}
                        {{ $property->status === 'rejected' ? 'bg-red-500/20 text-red-100' : '' }}">
                            <i
                                class="fas 
                            {{ $property->status === 'approved' ? 'fa-check-circle' : '' }}
                            {{ $property->status === 'pending' ? 'fa-clock' : '' }}
                            {{ $property->status === 'draft' ? 'fa-edit' : '' }}
                            {{ $property->status === 'rejected' ? 'fa-times-circle' : '' }}
                            mr-1"></i>
                            {{ ucfirst($property->status) }}
                        </span>

                        <div class="text-right">
                            <div class="text-3xl font-bold">{{ $property->formatted_price }}</div>
                            <div class="text-white/70 text-sm">
                                {{ $property->isForSale() ? 'Purchase Price' : 'Monthly Rent' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-8">

                {{-- Owner Information --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-2xl font-bold text-[#2F2B40] mb-2">Property Owner</h3>
                                <p class="text-gray-600">Contact information and details</p>
                            </div>
                            <i class="fas fa-user-circle text-3xl text-[#CBA660]"></i>
                        </div>
                    </div>

                    <div class="p-8">
                        <div class="flex items-center space-x-6">
                            <div class="flex-1">
                                <div class="text-xl font-bold text-[#2F2B40] mb-2">{{ $property->owner->name }}</div>
                                <div class="space-y-2">
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-envelope mr-3 text-[#CBA660]"></i>
                                        <span>{{ $property->owner->email }}</span>
                                    </div>
                                    <div class="flex items-center text-gray-500 text-sm">
                                        <i class="fas fa-calendar-alt mr-3 text-gray-400"></i>
                                        <span>Member since {{ $property->owner->created_at->format('M Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- Property Images --}}
                @if ($property->images->count() > 0)
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-2xl font-bold text-[#2F2B40] mb-2">Property Photos</h3>
                                    <p class="text-gray-600">{{ $property->images->count() }} professional photos</p>
                                </div>
                                <i class="fas fa-camera text-3xl text-[#CBA660]"></i>
                            </div>
                        </div>

                        <div class="p-8">
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach ($property->images as $image)
                                    <div
                                        class="relative group overflow-hidden rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                                        <img src="{{ $image->image_url }}" alt="{{ $image->alt_text }}"
                                            class="w-full h-40 object-cover group-hover:scale-110 transition-transform duration-300">
                                        <div
                                            class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all duration-300">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Property Details --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-2xl font-bold text-[#2F2B40] mb-2">Property Information</h3>
                                <p class="text-gray-600">Detailed specifications and features</p>
                            </div>
                            <i class="fas fa-info-circle text-3xl text-[#CBA660]"></i>
                        </div>
                    </div>

                    <div class="p-8 space-y-8">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                            @if ($property->bedrooms)
                                <div
                                    class="group text-center p-6 bg-gradient-to-br from-[#CBA660]/10 to-[#CBA660]/20 rounded-2xl border border-[#CBA660]/20 hover:border-[#CBA660]/30">
                                    <div
                                        class="w-16 h-16 bg-gradient-to-br from-[#CBA660] to-[#CBA660]/80 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                                        <i class="fas fa-bed text-2xl text-white"></i>
                                    </div>
                                    <div class="text-2xl font-bold text-[#2F2B40] mb-1">{{ $property->bedrooms }}</div>
                                    <div class="text-sm text-gray-600 font-medium">
                                        Bedroom{{ $property->bedrooms > 1 ? 's' : '' }}</div>
                                </div>
                            @endif

                            @if ($property->bathrooms)
                                <div
                                    class="group text-center p-6 bg-gradient-to-br from-[#CBA660]/10 to-[#CBA660]/20 rounded-2xl border border-[#CBA660]/20 hover:border-[#CBA660]/30">
                                    <div
                                        class="w-16 h-16 bg-gradient-to-br from-[#CBA660] to-[#CBA660]/80 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                                        <i class="fas fa-bath text-2xl text-white"></i>
                                    </div>
                                    <div class="text-2xl font-bold text-[#2F2B40] mb-1">{{ $property->bathrooms }}</div>
                                    <div class="text-sm text-gray-600 font-medium">
                                        Bathroom{{ $property->bathrooms > 1 ? 's' : '' }}</div>
                                </div>
                            @endif

                            @if ($property->area)
                                <div
                                    class="group text-center p-6 bg-gradient-to-br from-[#CBA660]/10 to-[#CBA660]/20 rounded-2xl border border-[#CBA660]/20 hover:border-[#CBA660]/30">
                                    <div
                                        class="w-16 h-16 bg-gradient-to-br from-[#CBA660] to-[#CBA660]/80 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                                        <i class="fas fa-ruler-combined text-2xl text-white"></i>
                                    </div>
                                    <div class="text-2xl font-bold text-[#2F2B40] mb-1">
                                        {{ number_format($property->area) }}</div>
                                    <div class="text-sm text-gray-600 font-medium">m² Area</div>
                                </div>
                            @endif

                            <div
                                class="group text-center p-6 bg-gradient-to-br from-[#CBA660]/10 to-[#CBA660]/20 rounded-2xl border border-[#CBA660]/20 hover:border-[#CBA660]/30">
                                <div
                                    class="w-16 h-16 bg-gradient-to-br from-[#CBA660] to-[#CBA660]/80 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                                    <i
                                        class="fas fa-{{ $property->isForSale() ? 'dollar-sign' : 'calendar' }} text-2xl text-white"></i>
                                </div>
                                <div class="text-2xl font-bold text-[#2F2B40] mb-1">
                                    {{ $property->isForSale() ? 'Sale' : 'Rent' }}</div>
                                <div class="text-sm text-gray-600 font-medium">Listing Type</div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <h4 class="text-xl font-bold text-[#2F2B40] mb-4 flex items-center">
                                <i class="fas fa-align-left mr-3 text-[#CBA660]"></i>Description
                            </h4>
                            <div
                                class="bg-gradient-to-br from-gray-50 to-gray-100/50 p-6 rounded-2xl border border-gray-100">
                                <div class="text-gray-700 leading-relaxed">
                                    {!! nl2br(e($property->description)) !!}
                                </div>
                            </div>
                        </div>

                        <!-- Features -->
                        @if ($property->features && count($property->features) > 0)
                            <div>
                                <h4 class="text-xl font-bold text-[#2F2B40] mb-4 flex items-center">
                                    <i class="fas fa-list-check mr-3 text-[#CBA660]"></i>Features & Amenities
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach ($property->features as $feature)
                                        <div
                                            class="flex items-center p-3 bg-gradient-to-r from-[#CBA660]/10 to-[#CBA660]/20 rounded-xl">
                                            <div
                                                class="w-8 h-8 bg-gradient-to-br from-[#CBA660] to-[#CBA660]/80 rounded-full flex items-center justify-center mr-3">
                                                <i class="fas fa-check text-white text-sm"></i>
                                            </div>
                                            <span class="text-gray-700 font-medium">{{ $feature }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                
            </div>

            
            <div class="space-y-8">
                
                @if ($property->status === 'pending')
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-6 py-4 border-b border-gray-100">
                            <h3 class="text-lg font-bold text-[#2F2B40] flex items-center">
                                <i class="fas fa-gavel mr-2 text-[#CBA660]"></i>Review Actions
                            </h3>
                        </div>

                        <div class="p-6">
                            <form action="{{ route('admin.properties.update-status', $property) }}" method="POST"
                                class="space-y-6">
                                @csrf
                                @method('PUT')

                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-[#2F2B40] mb-2">Decision *</label>
                                    <select name="status"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#CBA660]/20 focus:border-[#CBA660] transition-all duration-200 bg-gray-50/50"
                                        required>
                                        <option value="">Select Action</option>
                                        <option value="approved">Approve Property</option>
                                        <option value="rejected">Reject Property</option>
                                    </select>
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-[#2F2B40] mb-2">Admin Notes</label>
                                    <textarea name="admin_notes" rows="4" placeholder="Add notes about your decision..."
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#CBA660]/20 focus:border-[#CBA660] transition-all duration-200 bg-gray-50/50 resize-none"></textarea>
                                </div>

                                <button type="submit"
                                    class="w-full bg-gradient-to-r from-[#CBA660] to-[#CBA660]/80 text-white px-6 py-4 rounded-xl font-semibold shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                                    <i class="fas fa-check mr-2"></i>Submit Review
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-6 py-4 border-b border-gray-100">
                            <h3 class="text-lg font-bold text-[#2F2B40] flex items-center">
                                <i class="fas fa-clipboard-check mr-2 text-[#CBA660]"></i>Review Status
                            </h3>
                        </div>

                        <div class="p-6">
                            <div class="text-center py-4">
                                <div
                                    class="w-20 h-20 mx-auto mb-4 rounded-full flex items-center justify-center
                                {{ $property->status === 'approved' ? 'bg-green-100' : 'bg-red-100' }}">
                                    <i
                                        class="fas fa-{{ $property->status === 'approved' ? 'check-circle text-green-500' : 'times-circle text-red-500' }} text-4xl"></i>
                                </div>
                                <p class="text-xl font-bold text-[#2F2B40] mb-2">{{ ucfirst($property->status) }}</p>

                                @if ($property->approved_at)
                                    <p class="text-sm text-gray-600 mb-1">Approved on
                                        {{ $property->approved_at->format('M d, Y') }}</p>
                                @elseif($property->rejected_at)
                                    <p class="text-sm text-gray-600 mb-1">Rejected on
                                        {{ $property->rejected_at->format('M d, Y') }}</p>
                                @endif

                                @if ($property->reviewer)
                                    <p class="text-sm text-gray-600">by {{ $property->reviewer->name }}</p>
                                @endif
                            </div>

                            @if ($property->admin_notes)
                                <div class="border-t pt-4 mt-4">
                                    <h4 class="font-semibold text-sm text-[#2F2B40] mb-3 flex items-center">
                                        <i class="fas fa-sticky-note mr-2 text-[#CBA660]"></i>Admin Notes:
                                    </h4>
                                    <div
                                        class="bg-gradient-to-br from-gray-50 to-gray-100/50 p-4 rounded-xl border border-gray-100">
                                        <p class="text-sm text-gray-700">{{ $property->admin_notes }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
                


                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-6 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-bold text-[#2F2B40] flex items-center">
                            <i class="fas fa-bolt mr-2 text-[#CBA660]"></i>Quick Actions
                        </h3>
                    </div>

                    <div class="p-6 space-y-4">
                        <a href="{{ route('admin.properties.index') }}"
                            class="block w-full text-center px-6 py-3 border border-[#CBA660] text-[#CBA660] rounded-xl hover:bg-[#CBA660] hover:text-white transition-all duration-200 font-medium shadow-sm hover:shadow-md">
                            <i class="fas fa-arrow-left mr-2"></i>Back to Properties
                        </a>

                        @if ($property->status === 'approved' && $property->payment_completed)
                            <a href="{{ route('properties.show', $property) }}" target="_blank"
                                class="block w-full text-center px-6 py-3 border border-blue-500 text-blue-600 rounded-xl hover:bg-blue-500 hover:text-white transition-all duration-200 font-medium shadow-sm hover:shadow-md">
                                <i class="fas fa-external-link-alt mr-2"></i>View Public Page
                            </a>
                        @endif

                        <form action="{{ route('admin.properties.destroy', $property) }}" method="POST" class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full px-6 py-3 border border-red-500 text-red-600 rounded-xl hover:bg-red-500 hover:text-white transition-all duration-200 font-medium shadow-sm hover:shadow-md"
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
