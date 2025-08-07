@extends('layouts.dashboard')

@section('title', 'Edit Property - Owner Dashboard')
@section('page-title', 'Edit Property')

@section('content')
    <div class="space-y-8">
        
        <div
            class="relative overflow-hidden bg-gradient-to-r from-[#2F2B40] to-[#CBA660] rounded-2xl p-8 text-white shadow-2xl">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-12 -translate-x-12"></div>

            <div class="relative z-10 flex items-center justify-between">
                <div class="flex items-center space-x-6">
                    <div>
                        <h2 class="text-3xl font-bold mb-2">Edit Property</h2>
                        <h3 class="text-xl font-semibold mb-2">Status: {{ ucfirst($property->status) }}</h3>
                        <p class="text-white/80">
                            @if ($property->status === 'draft')
                                This property is saved as a draft. Submit for review to publish it.
                            @elseif($property->status === 'pending')
                                This property is pending admin approval.
                            @elseif($property->status === 'approved')
                                This property is approved and published.
                            @elseif($property->status === 'rejected')
                                This property was rejected. Please review and resubmit.
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Property Form --}}
        <form action="{{ route('owner.properties.update', $property) }}" method="POST" enctype="multipart/form-data"
            class="space-y-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-8">
                    
                    <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-2xl font-bold text-[#2F2B40] mb-2">Basic Information</h3>
                                    <p class="text-gray-600">Essential details about your property</p>
                                </div>
                                <div
                                    class="w-14 h-14 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-info-circle text-[#CBA660] text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="p-8 space-y-6">
                            <div>
                                <label class="block text-sm font-semibold text-[#2F2B40] mb-2">Property Title *</label>
                                <input type="text" name="title" value="{{ old('title', $property->title) }}"
                                    placeholder="e.g., Beautiful 3-bedroom apartment in Casablanca"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#CBA660]/20 focus:border-[#CBA660] transition-all duration-300 bg-gray-50 focus:bg-white"
                                    required>
                                @error('title')
                                    <p class="text-red-500 text-sm mt-2 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-[#2F2B40] mb-2">Property Type *</label>
                                    <select name="category_id"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#CBA660]/20 focus:border-[#CBA660] transition-all duration-300 bg-gray-50 focus:bg-white"
                                        required>
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id', $property->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <p class="text-red-500 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-[#2F2B40] mb-2">Listing Type *</label>
                                    <select name="listing_type"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#CBA660]/20 focus:border-[#CBA660] transition-all duration-300 bg-gray-50 focus:bg-white"
                                        required>
                                        <option value="sale"
                                            {{ old('listing_type', $property->listing_type) == 'sale' ? 'selected' : '' }}>
                                            For Sale</option>
                                        <option value="rent"
                                            {{ old('listing_type', $property->listing_type) == 'rent' ? 'selected' : '' }}>
                                            For Rent</option>
                                    </select>
                                    @error('listing_type')
                                        <p class="text-red-500 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-[#2F2B40] mb-2">Description *</label>
                                <textarea name="description" rows="4" placeholder="Describe your property in detail..."
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#CBA660]/20 focus:border-[#CBA660] transition-all duration-300 bg-gray-50 focus:bg-white resize-none"
                                    required>{{ old('description', $property->description) }}</textarea>
                                @error('description')
                                    <p class="text-red-500 text-sm mt-2 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    
                    <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-2xl font-bold text-[#2F2B40] mb-2">Location</h3>
                                    <p class="text-gray-600">Where is your property located?</p>
                                </div>
                                <div
                                    class="w-14 h-14 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-map-marker-alt text-[#CBA660] text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="p-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-[#2F2B40] mb-2">City *</label>
                                    <select name="city_id"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#CBA660]/20 focus:border-[#CBA660] transition-all duration-300 bg-gray-50 focus:bg-white"
                                        required>
                                        <option value="">Select City</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}"
                                                {{ old('city_id', $property->city_id) == $city->id ? 'selected' : '' }}>
                                                {{ $city->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('city_id')
                                        <p class="text-red-500 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-[#2F2B40] mb-2">Address *</label>
                                    <input type="text" name="address" value="{{ old('address', $property->address) }}"
                                        placeholder="Full address"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#CBA660]/20 focus:border-[#CBA660] transition-all duration-300 bg-gray-50 focus:bg-white"
                                        required>
                                    @error('address')
                                        <p class="text-red-500 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-2xl font-bold text-[#2F2B40] mb-2">Property Details</h3>
                                    <p class="text-gray-600">Specifications and pricing</p>
                                </div>
                                <div
                                    class="w-14 h-14 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-home text-[#CBA660] text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="p-8">
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-[#2F2B40] mb-2">Bedrooms</label>
                                    <input type="number" name="bedrooms"
                                        value="{{ old('bedrooms', $property->bedrooms) }}" min="0" placeholder="0"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#CBA660]/20 focus:border-[#CBA660] transition-all duration-300 bg-gray-50 focus:bg-white">
                                    @error('bedrooms')
                                        <p class="text-red-500 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-[#2F2B40] mb-2">Bathrooms</label>
                                    <input type="number" name="bathrooms"
                                        value="{{ old('bathrooms', $property->bathrooms) }}" min="0"
                                        placeholder="0"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#CBA660]/20 focus:border-[#CBA660] transition-all duration-300 bg-gray-50 focus:bg-white">
                                    @error('bathrooms')
                                        <p class="text-red-500 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-[#2F2B40] mb-2">Area (m²)</label>
                                    <input type="number" name="area" value="{{ old('area', $property->area) }}"
                                        min="0" placeholder="0"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#CBA660]/20 focus:border-[#CBA660] transition-all duration-300 bg-gray-50 focus:bg-white">
                                    @error('area')
                                        <p class="text-red-500 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-[#2F2B40] mb-2">Price (MAD) *</label>
                                    <input type="number" name="price" value="{{ old('price', $property->price) }}"
                                        min="0" placeholder="0"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#CBA660]/20 focus:border-[#CBA660] transition-all duration-300 bg-gray-50 focus:bg-white"
                                        required>
                                    @error('price')
                                        <p class="text-red-500 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-2xl font-bold text-[#2F2B40] mb-2">Features & Amenities</h3>
                                    <p class="text-gray-600">Select all applicable features</p>
                                </div>
                                <div
                                    class="w-14 h-14 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-star text-[#CBA660] text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="p-8">
                            @php
                                $availableFeatures = [
                                    'Swimming Pool',
                                    'Garden',
                                    'Garage',
                                    'Security System',
                                    'Air Conditioning',
                                    'Balcony',
                                    'Parking',
                                    'Elevator',
                                    'Furnished',
                                ];
                                $propertyFeatures = old('features', $property->features ?? []);
                            @endphp

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach ($availableFeatures as $feature)
                                    <label
                                        class="group relative flex items-center bg-gradient-to-br from-gray-50 to-gray-100/50 p-4 rounded-xl border border-gray-200 hover:border-[#CBA660]/50 hover:shadow-md transition-all duration-300 cursor-pointer">
                                        <input type="checkbox" name="features[]" value="{{ $feature }}"
                                            {{ in_array($feature, $propertyFeatures) ? 'checked' : '' }}
                                            class="w-5 h-5 text-[#CBA660] bg-gray-100 border-gray-300 rounded focus:ring-[#CBA660]/20 focus:ring-2 transition-all duration-300">
                                        <span
                                            class="ml-3 text-sm font-medium text-gray-700 group-hover:text-[#2F2B40] transition-colors duration-300">{{ $feature }}</span>
                                        <div
                                            class="absolute top-2 right-2 w-6 h-6 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                            <i class="fas fa-check text-[#CBA660] text-xs"></i>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="space-y-6">
                    
                    @if ($property->images->count() > 0)
                        <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                            <div
                                class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-6 py-4 border-b border-gray-100">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-xl font-bold text-[#2F2B40] mb-1">Current Photos</h3>
                                        <p class="text-gray-600 text-sm">{{ $property->images->count() }} images</p>
                                    </div>
                                    <i class="fas fa-images text-2xl text-[#CBA660]"></i>
                                </div>
                            </div>

                            <div class="p-6">
                                <div class="grid grid-cols-2 gap-3">
                                    @foreach ($property->images as $image)
                                        <div class="group relative overflow-hidden rounded-xl">
                                            <img src="{{ $image->image_url }}" alt="{{ $image->alt_text }}"
                                                class="w-full h-24 object-cover transition-transform duration-300 group-hover:scale-110">

                                            <label class="absolute top-2 right-2 cursor-pointer">
                                                <input type="checkbox" name="remove_images[]"
                                                    value="{{ $image->id }}" class="sr-only remove-image-checkbox">
                                                <div
                                                    class="w-7 h-7 bg-red-500 text-white rounded-full flex items-center justify-center text-sm hover:bg-red-600 transition-colors duration-300 shadow-lg">
                                                    <i class="fas fa-times"></i>
                                                </div>
                                            </label>

                                            @if ($image->is_featured)
                                                <div
                                                    class="absolute bottom-2 left-2 bg-gradient-to-r from-[#CBA660] to-[#CBA660]/80 text-white text-xs px-2 py-1 rounded-full font-semibold">
                                                    <i class="fas fa-star mr-1"></i>Featured
                                                </div>
                                            @endif

                                            
                                            <div
                                                class="remove-overlay absolute inset-0 bg-red-500/80 backdrop-blur-sm hidden items-center justify-center">
                                                <div class="text-white text-center">
                                                    <i class="fas fa-trash text-2xl mb-2"></i>
                                                    <p class="text-sm font-semibold">Will be removed</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-xl">
                                    <p class="text-xs text-yellow-800 flex items-center">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        Click the X button to mark photos for removal
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    
                    <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-6 py-4 border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-xl font-bold text-[#2F2B40] mb-1">Add New Photos</h3>
                                    <p class="text-gray-600 text-sm">Upload additional images</p>
                                </div>
                                <i class="fas fa-camera text-2xl text-[#CBA660]"></i>
                            </div>
                        </div>

                        <div class="p-6 space-y-4">
                            <div
                                class="border-2 border-dashed border-[#CBA660]/30 rounded-2xl p-8 text-center bg-gradient-to-br from-[#CBA660]/5 to-[#CBA660]/10 hover:border-[#CBA660]/50 transition-all duration-300">
                                <i class="fas fa-cloud-upload-alt text-4xl text-[#CBA660] mb-4"></i>
                                <p class="text-sm text-gray-600 mb-4">Drag and drop or click to upload</p>
                                <input type="file" name="images[]" multiple accept="image/*" class="hidden"
                                    id="property-images">
                                <label for="property-images"
                                    class="bg-[#CBA660] text-white px-6 py-3 rounded-xl hover:bg-[#CBA660]/80 transition-all duration-300 cursor-pointer inline-flex items-center font-medium">
                                    <i class="fas fa-plus mr-2"></i>Choose Files
                                </label>
                            </div>

                            <div id="image-preview" class="grid grid-cols-2 gap-3 hidden"></div>

                            @error('images.*')
                                <p
                                    class="text-red-500 text-sm flex items-center bg-red-50 border border-red-200 rounded-xl p-3">
                                    <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    
                    <div class="space-y-4">
                        <button type="submit"
                            class="group relative bg-gradient-to-br from-[#CBA660] to-[#CBA660]/80 text-white p-4 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 overflow-hidden w-full">
                            <div
                                class="absolute top-0 right-0 w-12 h-12 bg-white/10 rounded-full -translate-y-6 translate-x-6">
                            </div>
                            <div class="relative z-10 text-center">
                                <i class="fas fa-save text-xl mb-2 block"></i>
                                <span class="font-semibold">Update Property</span>
                            </div>
                        </button>

                        @if ($property->status === 'draft')
                            <button type="submit" name="submit_for_review" value="1"
                                class="group relative bg-white border border-[#CBA660] text-[#CBA660] p-4 rounded-xl hover:bg-[#CBA660]/5 transition-all duration-300 transform hover:scale-105 w-full">
                                <div class="text-center">
                                    <i class="fas fa-paper-plane text-xl mb-2 block"></i>
                                    <span class="font-semibold">Update & Submit for Review</span>
                                </div>
                            </button>
                        @endif

                        <a href="{{ route('owner.properties.index') }}"
                            class="group relative bg-white border border-gray-300 text-gray-600 p-4 rounded-xl hover:border-[#CBA660] hover:text-[#CBA660] transition-all duration-300 transform hover:scale-105 w-full block">
                            <div class="text-center">
                                <i class="fas fa-arrow-left text-xl mb-2 block"></i>
                                <span class="font-semibold">Back to Properties</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
