@extends('layouts.dashboard')

@section('title', 'Add New Property - Owner Dashboard')
@section('page-title', 'Add New Property')

@section('content')
    <div class="space-y-8">
        
        <div
            class="relative overflow-hidden bg-gradient-to-r from-[#2F2B40] to-[#CBA660] rounded-2xl p-8 text-white shadow-2xl">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-12 -translate-x-12"></div>

            <div class="relative z-10">
                <h2 class="text-3xl font-bold mb-2">Add New Property</h2>
                <p class="text-white/80 text-lg">Create a compelling listing to attract potential buyers or tenants</p>
            </div>
        </div>

        

        
        <form action="{{ route('owner.properties.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-8">
                    {{-- Basic Information --}}
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
                            <h3 class="text-xl font-bold text-[#2F2B40] flex items-center">
                                <i class="fas fa-info-circle mr-3 text-[#CBA660]"></i>
                                Basic Information
                            </h3>
                            <p class="text-gray-600 text-sm mt-1">Tell us about your property</p>
                        </div>

                        <div class="p-8 space-y-6">
                            <div>
                                <label class="block text-sm font-semibold text-[#2F2B40] mb-2">Property Title *</label>
                                <input type="text" name="title" value="{{ old('title') }}"
                                    placeholder="e.g., Beautiful 3-bedroom apartment in Casablanca"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-[#CBA660] focus:ring-2 focus:ring-[#CBA660]/20 transition-all duration-300 hover:border-[#CBA660]/50"
                                    required>
                                @error('title')
                                    <p class="text-red-500 text-sm mt-2 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-[#2F2B40] mb-2">Property Type *</label>
                                    <select name="category_id"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-[#CBA660] focus:ring-2 focus:ring-[#CBA660]/20 transition-all duration-300 hover:border-[#CBA660]/50"
                                        required>
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <p class="text-red-500 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-[#2F2B40] mb-2">Listing Type *</label>
                                    <select name="listing_type"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-[#CBA660] focus:ring-2 focus:ring-[#CBA660]/20 transition-all duration-300 hover:border-[#CBA660]/50"
                                        required>
                                        <option value="sale" {{ old('listing_type') == 'sale' ? 'selected' : '' }}>For
                                            Sale</option>
                                        <option value="rent" {{ old('listing_type') == 'rent' ? 'selected' : '' }}>For
                                            Rent</option>
                                    </select>
                                    @error('listing_type')
                                        <p class="text-red-500 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-[#2F2B40] mb-2">Description *</label>
                                <textarea name="description" rows="4" placeholder="Describe your property in detail..."
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-[#CBA660] focus:ring-2 focus:ring-[#CBA660]/20 transition-all duration-300 hover:border-[#CBA660]/50 resize-none"
                                    required>{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="text-red-500 text-sm mt-2 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Location -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
                            <h3 class="text-xl font-bold text-[#2F2B40] flex items-center">
                                <i class="fas fa-map-marker-alt mr-3 text-[#CBA660]"></i>
                                Location
                            </h3>
                            <p class="text-gray-600 text-sm mt-1">Where is your property located?</p>
                        </div>

                        <div class="p-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-[#2F2B40] mb-2">City *</label>
                                    <select name="city_id"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-[#CBA660] focus:ring-2 focus:ring-[#CBA660]/20 transition-all duration-300 hover:border-[#CBA660]/50"
                                        required>
                                        <option value="">Select City</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}"
                                                {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                                {{ $city->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('city_id')
                                        <p class="text-red-500 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-[#2F2B40] mb-2">Address *</label>
                                    <input type="text" name="address" value="{{ old('address') }}"
                                        placeholder="Full address"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-[#CBA660] focus:ring-2 focus:ring-[#CBA660]/20 transition-all duration-300 hover:border-[#CBA660]/50"
                                        required>
                                    @error('address')
                                        <p class="text-red-500 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Property Details -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
                            <h3 class="text-xl font-bold text-[#2F2B40] flex items-center">
                                <i class="fas fa-home mr-3 text-[#CBA660]"></i>
                                Property Details
                            </h3>
                            <p class="text-gray-600 text-sm mt-1">Specifications and pricing</p>
                        </div>

                        <div class="p-8">
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-[#2F2B40] mb-2">
                                        <i class="fas fa-bed mr-1 text-[#CBA660]"></i>Bedrooms
                                    </label>
                                    <input type="number" name="bedrooms" value="{{ old('bedrooms') }}" min="0"
                                        placeholder="0"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-[#CBA660] focus:ring-2 focus:ring-[#CBA660]/20 transition-all duration-300 hover:border-[#CBA660]/50">
                                    @error('bedrooms')
                                        <p class="text-red-500 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-[#2F2B40] mb-2">
                                        <i class="fas fa-bath mr-1 text-[#CBA660]"></i>Bathrooms
                                    </label>
                                    <input type="number" name="bathrooms" value="{{ old('bathrooms') }}"
                                        min="0" placeholder="0"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-[#CBA660] focus:ring-2 focus:ring-[#CBA660]/20 transition-all duration-300 hover:border-[#CBA660]/50">
                                    @error('bathrooms')
                                        <p class="text-red-500 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-[#2F2B40] mb-2">
                                        <i class="fas fa-ruler-combined mr-1 text-[#CBA660]"></i>Area (m²)
                                    </label>
                                    <input type="number" name="area" value="{{ old('area') }}" min="0"
                                        placeholder="0"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-[#CBA660] focus:ring-2 focus:ring-[#CBA660]/20 transition-all duration-300 hover:border-[#CBA660]/50">
                                    @error('area')
                                        <p class="text-red-500 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-[#2F2B40] mb-2">
                                        <i class="fas fa-money-bill-wave mr-1 text-[#CBA660]"></i>Price (MAD) *
                                    </label>
                                    <input type="number" name="price" value="{{ old('price') }}" min="0"
                                        placeholder="0"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-[#CBA660] focus:ring-2 focus:ring-[#CBA660]/20 transition-all duration-300 hover:border-[#CBA660]/50"
                                        required>
                                    @error('price')
                                        <p class="text-red-500 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Features -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
                            <h3 class="text-xl font-bold text-[#2F2B40] flex items-center">
                                <i class="fas fa-star mr-3 text-[#CBA660]"></i>
                                Features & Amenities
                            </h3>
                            <p class="text-gray-600 text-sm mt-1">What makes your property special?</p>
                        </div>

                        <div class="p-8">
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                <label
                                    class="flex items-center p-3 bg-gray-50 rounded-xl hover:bg-[#CBA660]/5 transition-all duration-300 cursor-pointer group">
                                    <input type="checkbox" name="features[]" value="Swimming Pool"
                                        {{ in_array('Swimming Pool', old('features', [])) ? 'checked' : '' }}
                                        class="mr-3 text-[#CBA660] rounded focus:ring-[#CBA660]">
                                    <i
                                        class="fas fa-swimming-pool mr-2 text-[#CBA660] group-hover:scale-110 transition-transform duration-300"></i>
                                    <span class="text-sm font-medium text-[#2F2B40]">Swimming Pool</span>
                                </label>
                                <label
                                    class="flex items-center p-3 bg-gray-50 rounded-xl hover:bg-[#CBA660]/5 transition-all duration-300 cursor-pointer group">
                                    <input type="checkbox" name="features[]" value="Garden"
                                        {{ in_array('Garden', old('features', [])) ? 'checked' : '' }}
                                        class="mr-3 text-[#CBA660] rounded focus:ring-[#CBA660]">
                                    <i
                                        class="fas fa-seedling mr-2 text-[#CBA660] group-hover:scale-110 transition-transform duration-300"></i>
                                    <span class="text-sm font-medium text-[#2F2B40]">Garden</span>
                                </label>
                                <label
                                    class="flex items-center p-3 bg-gray-50 rounded-xl hover:bg-[#CBA660]/5 transition-all duration-300 cursor-pointer group">
                                    <input type="checkbox" name="features[]" value="Garage"
                                        {{ in_array('Garage', old('features', [])) ? 'checked' : '' }}
                                        class="mr-3 text-[#CBA660] rounded focus:ring-[#CBA660]">
                                    <i
                                        class="fas fa-warehouse mr-2 text-[#CBA660] group-hover:scale-110 transition-transform duration-300"></i>
                                    <span class="text-sm font-medium text-[#2F2B40]">Garage</span>
                                </label>
                                <label
                                    class="flex items-center p-3 bg-gray-50 rounded-xl hover:bg-[#CBA660]/5 transition-all duration-300 cursor-pointer group">
                                    <input type="checkbox" name="features[]" value="Security System"
                                        {{ in_array('Security System', old('features', [])) ? 'checked' : '' }}
                                        class="mr-3 text-[#CBA660] rounded focus:ring-[#CBA660]">
                                    <i
                                        class="fas fa-shield-alt mr-2 text-[#CBA660] group-hover:scale-110 transition-transform duration-300"></i>
                                    <span class="text-sm font-medium text-[#2F2B40]">Security System</span>
                                </label>
                                <label
                                    class="flex items-center p-3 bg-gray-50 rounded-xl hover:bg-[#CBA660]/5 transition-all duration-300 cursor-pointer group">
                                    <input type="checkbox" name="features[]" value="Air Conditioning"
                                        {{ in_array('Air Conditioning', old('features', [])) ? 'checked' : '' }}
                                        class="mr-3 text-[#CBA660] rounded focus:ring-[#CBA660]">
                                    <i
                                        class="fas fa-snowflake mr-2 text-[#CBA660] group-hover:scale-110 transition-transform duration-300"></i>
                                    <span class="text-sm font-medium text-[#2F2B40]">Air Conditioning</span>
                                </label>
                                <label
                                    class="flex items-center p-3 bg-gray-50 rounded-xl hover:bg-[#CBA660]/5 transition-all duration-300 cursor-pointer group">
                                    <input type="checkbox" name="features[]" value="Balcony"
                                        {{ in_array('Balcony', old('features', [])) ? 'checked' : '' }}
                                        class="mr-3 text-[#CBA660] rounded focus:ring-[#CBA660]">
                                    <i
                                        class="fas fa-city mr-2 text-[#CBA660] group-hover:scale-110 transition-transform duration-300"></i>
                                    <span class="text-sm font-medium text-[#2F2B40]">Balcony</span>
                                </label>
                                <label
                                    class="flex items-center p-3 bg-gray-50 rounded-xl hover:bg-[#CBA660]/5 transition-all duration-300 cursor-pointer group">
                                    <input type="checkbox" name="features[]" value="Parking"
                                        {{ in_array('Parking', old('features', [])) ? 'checked' : '' }}
                                        class="mr-3 text-[#CBA660] rounded focus:ring-[#CBA660]">
                                    <i
                                        class="fas fa-parking mr-2 text-[#CBA660] group-hover:scale-110 transition-transform duration-300"></i>
                                    <span class="text-sm font-medium text-[#2F2B40]">Parking</span>
                                </label>
                                <label
                                    class="flex items-center p-3 bg-gray-50 rounded-xl hover:bg-[#CBA660]/5 transition-all duration-300 cursor-pointer group">
                                    <input type="checkbox" name="features[]" value="Elevator"
                                        {{ in_array('Elevator', old('features', [])) ? 'checked' : '' }}
                                        class="mr-3 text-[#CBA660] rounded focus:ring-[#CBA660]">
                                    <i
                                        class="fas fa-elevator mr-2 text-[#CBA660] group-hover:scale-110 transition-transform duration-300"></i>
                                    <span class="text-sm font-medium text-[#2F2B40]">Elevator</span>
                                </label>
                                <label
                                    class="flex items-center p-3 bg-gray-50 rounded-xl hover:bg-[#CBA660]/5 transition-all duration-300 cursor-pointer group">
                                    <input type="checkbox" name="features[]" value="Furnished"
                                        {{ in_array('Furnished', old('features', [])) ? 'checked' : '' }}
                                        class="mr-3 text-[#CBA660] rounded focus:ring-[#CBA660]">
                                    <i
                                        class="fas fa-couch mr-2 text-[#CBA660] group-hover:scale-110 transition-transform duration-300"></i>
                                    <span class="text-sm font-medium text-[#2F2B40]">Furnished</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="space-y-8">
                    
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
                            <h3 class="text-xl font-bold text-[#2F2B40] flex items-center">
                                <i class="fas fa-camera mr-3 text-[#CBA660]"></i>
                                Property Photos
                            </h3>
                            <p class="text-gray-600 text-sm mt-1">High-quality photos get more views</p>
                        </div>

                        <div class="p-8 space-y-4">
                            <div
                                class="border-2 border-dashed border-[#CBA660]/30 rounded-2xl p-8 text-center bg-gradient-to-br from-[#CBA660]/5 to-[#CBA660]/10 hover:border-[#CBA660] transition-all duration-300">
                                <div
                                    class="w-16 h-16 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-cloud-upload-alt text-2xl text-[#CBA660]"></i>
                                </div>
                                <p class="text-sm text-[#2F2B40] font-semibold mb-2">Upload property photos</p>
                                <p class="text-xs text-gray-600 mb-4">Drag & drop or click to browse</p>
                                <input type="file" name="images[]" multiple accept="image/*" class="hidden"
                                    id="property-images">
                                <label for="property-images"
                                    class="inline-flex items-center bg-white border border-[#CBA660] text-[#CBA660] px-6 py-2 rounded-xl hover:bg-[#CBA660]/5 transition-all duration-300 text-sm font-medium cursor-pointer">
                                    <i class="fas fa-plus mr-2"></i>Choose Files
                                </label>
                            </div>

                            <div id="image-preview" class="grid grid-cols-2 gap-3 hidden"></div>

                            <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 rounded-xl p-4">
                                <p class="text-xs text-gray-600 flex items-center">
                                    <i class="fas fa-lightbulb text-[#CBA660] mr-2"></i>
                                    Upload up to 10 high-quality photos. First photo will be the featured image.
                                </p>
                            </div>
                            @error('images.*')
                                <p class="text-red-500 text-sm flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
                            <h3 class="text-xl font-bold text-[#2F2B40] flex items-center">
                                <i class="fas fa-calculator mr-3 text-[#CBA660]"></i>
                                Pricing Information
                            </h3>
                            <p class="text-gray-600 text-sm mt-1">Fee breakdown</p>
                        </div>

                        <div class="p-8">
                            <div class="space-y-4 text-sm">
                                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                                    <span class="text-gray-600 font-medium">Listing Fee (5%):</span>
                                    <span class="font-bold text-[#2F2B40] pricing-fee">0 MAD</span>
                                </div>
                                <div
                                    class="flex justify-between items-center p-3 bg-gradient-to-r from-[#CBA660]/10 to-[#CBA660]/20 rounded-xl">
                                    <span class="text-[#2F2B40] font-semibold">Your Earnings:</span>
                                    <span class="font-bold text-[#2F2B40] pricing-earnings">0 MAD</span>
                                </div>
                                <div class="border-t border-gray-200 pt-4">
                                    <p class="text-xs text-gray-500 flex items-center">
                                        <i class="fas fa-info-circle text-[#CBA660] mr-2"></i>
                                        The listing fee is charged only after your property is approved and published.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-4">
                        <button type="submit" name="submit_for_review"
                            class="w-full bg-gradient-to-r from-[#CBA660] to-[#CBA660]/80 text-white font-semibold px-6 py-4 rounded-xl hover:shadow-lg transition-all duration-300 transform hover:scale-105 flex items-center justify-center">
                            <i class="fas fa-paper-plane mr-2"></i>Submit for Review
                        </button>
                        <a href="{{ route('owner.properties.index') }}"
                            class="w-full bg-gray-100 text-gray-600 font-semibold px-6 py-4 rounded-xl hover:bg-gray-200 transition-all duration-300 flex items-center justify-center">
                            <i class="fas fa-times mr-2"></i>Cancel
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            document.getElementById('property-images').addEventListener('change', function(e) {
                const files = e.target.files;
                const preview = document.getElementById('image-preview');

                if (files.length > 0) {
                    preview.classList.remove('hidden');
                    preview.innerHTML = '';

                    Array.from(files).forEach((file, index) => {
                        if (file.type.startsWith('image/')) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const div = document.createElement('div');
                                div.className = 'relative group';
                                div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-24 object-cover rounded-xl">
                        <div class="absolute top-2 left-2 bg-gradient-to-r from-[#CBA660] to-[#CBA660]/80 text-white text-xs px-2 py-1 rounded-lg font-semibold">
                            ${index === 0 ? 'Featured' : index + 1}
                        </div>
                        <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl"></div>
                    `;
                                preview.appendChild(div);
                            };
                            reader.readAsDataURL(file);
                        }
                    });
                } else {
                    preview.classList.add('hidden');
                }
            });

            // Dynamic pricing calculation
            document.querySelector('input[name="price"]').addEventListener('input', function(e) {
                const price = parseFloat(e.target.value) || 0;
                const fee = price * 0.05;
                const earnings = price - fee;

                document.querySelector('.pricing-fee').textContent = fee.toLocaleString() + ' MAD';
                document.querySelector('.pricing-earnings').textContent = earnings.toLocaleString() + ' MAD';
            });

            // Add smooth focus animations
            document.querySelectorAll('input, select, textarea').forEach(element => {
                element.addEventListener('focus', function() {
                    this.parentElement.classList.add('transform', 'scale-[1.02]');
                });

                element.addEventListener('blur', function() {
                    this.parentElement.classList.remove('transform', 'scale-[1.02]');
                });
            });
        </script>
    @endpush
@endsection
