@extends('layouts.dashboard')

@section('title', 'Add New Property - Owner Dashboard')
@section('page-title', 'Add New Property')

@section('breadcrumb')
<a href="{{ route('owner.dashboard') }}" class="hover:text-brand-dark">Dashboard</a>
<span class="mx-2">/</span>
<a href="{{ route('owner.properties.index') }}" class="hover:text-brand-dark">My Properties</a>
<span class="mx-2">/</span>
<span>Add New</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Progress Steps -->
    <div class="dashboard-card">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-brand-beige text-brand-dark rounded-full flex items-center justify-center text-sm font-semibold">1</div>
                    <span class="ml-2 text-sm font-medium">Property Details</span>
                </div>
                <div class="w-8 h-0.5 bg-gray-300"></div>
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-semibold">2</div>
                    <span class="ml-2 text-sm text-gray-600">Photos & Media</span>
                </div>
                <div class="w-8 h-0.5 bg-gray-300"></div>
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-semibold">3</div>
                    <span class="ml-2 text-sm text-gray-600">Review & Publish</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Property Form -->
    <form action="{{ route('owner.properties.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Information -->
                <div class="dashboard-card">
                    <div class="dashboard-card-header">
                        <h3 class="dashboard-card-title">Basic Information</h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="form-label">Property Title *</label>
                            <input type="text" name="title" value="{{ old('title') }}" placeholder="e.g., Beautiful 3-bedroom apartment in Casablanca" class="form-input" required>
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="form-label">Property Type *</label>
                                <select name="category_id" class="form-input" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label">Listing Type *</label>
                                <select name="listing_type" class="form-input" required>
                                    <option value="sale" {{ old('listing_type') == 'sale' ? 'selected' : '' }}>For Sale</option>
                                    <option value="rent" {{ old('listing_type') == 'rent' ? 'selected' : '' }}>For Rent</option>
                                </select>
                                @error('listing_type')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label class="form-label">Description *</label>
                            <textarea name="description" rows="4" placeholder="Describe your property in detail..." class="form-input" required>{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Location -->
                <div class="dashboard-card">
                    <div class="dashboard-card-header">
                        <h3 class="dashboard-card-title">Location</h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="form-label">City *</label>
                                <select name="city_id" class="form-input" required>
                                    <option value="">Select City</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('city_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label">Address *</label>
                                <input type="text" name="address" value="{{ old('address') }}" placeholder="Full address" class="form-input" required>
                                @error('address')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Property Details -->
                <div class="dashboard-card">
                    <div class="dashboard-card-header">
                        <h3 class="dashboard-card-title">Property Details</h3>
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <label class="form-label">Bedrooms</label>
                            <input type="number" name="bedrooms" value="{{ old('bedrooms') }}" min="0" placeholder="0" class="form-input">
                            @error('bedrooms')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label">Bathrooms</label>
                            <input type="number" name="bathrooms" value="{{ old('bathrooms') }}" min="0" placeholder="0" class="form-input">
                            @error('bathrooms')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label">Area (m²)</label>
                            <input type="number" name="area" value="{{ old('area') }}" min="0" placeholder="0" class="form-input">
                            @error('area')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label">Price (MAD) *</label>
                            <input type="number" name="price" value="{{ old('price') }}" min="0" placeholder="0" class="form-input" required>
                            @error('price')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Features -->
                <div class="dashboard-card">
                    <div class="dashboard-card-header">
                        <h3 class="dashboard-card-title">Features & Amenities</h3>
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        <label class="flex items-center">
                            <input type="checkbox" name="features[]" value="Swimming Pool" {{ in_array('Swimming Pool', old('features', [])) ? 'checked' : '' }} class="mr-2">
                            <span class="text-sm">Swimming Pool</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="features[]" value="Garden" {{ in_array('Garden', old('features', [])) ? 'checked' : '' }} class="mr-2">
                            <span class="text-sm">Garden</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="features[]" value="Garage" {{ in_array('Garage', old('features', [])) ? 'checked' : '' }} class="mr-2">
                            <span class="text-sm">Garage</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="features[]" value="Security System" {{ in_array('Security System', old('features', [])) ? 'checked' : '' }} class="mr-2">
                            <span class="text-sm">Security System</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="features[]" value="Air Conditioning" {{ in_array('Air Conditioning', old('features', [])) ? 'checked' : '' }} class="mr-2">
                            <span class="text-sm">Air Conditioning</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="features[]" value="Balcony" {{ in_array('Balcony', old('features', [])) ? 'checked' : '' }} class="mr-2">
                            <span class="text-sm">Balcony</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="features[]" value="Parking" {{ in_array('Parking', old('features', [])) ? 'checked' : '' }} class="mr-2">
                            <span class="text-sm">Parking</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="features[]" value="Elevator" {{ in_array('Elevator', old('features', [])) ? 'checked' : '' }} class="mr-2">
                            <span class="text-sm">Elevator</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="features[]" value="Furnished" {{ in_array('Furnished', old('features', [])) ? 'checked' : '' }} class="mr-2">
                            <span class="text-sm">Furnished</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Photo Upload -->
                <div class="dashboard-card">
                    <div class="dashboard-card-header">
                        <h3 class="dashboard-card-title">Property Photos</h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                            <p class="text-sm text-gray-600 mb-2">Upload property photos</p>
                            <input type="file" name="images[]" multiple accept="image/*" class="hidden" id="property-images">
                            <label for="property-images" class="btn-outline text-sm cursor-pointer">Choose Files</label>
                        </div>

                        <div id="image-preview" class="grid grid-cols-2 gap-2 hidden"></div>

                        <p class="text-xs text-gray-500">
                            Upload up to 10 high-quality photos. First photo will be the featured image.
                        </p>
                        @error('images.*')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Pricing Info -->
                <div class="dashboard-card">
                    <div class="dashboard-card-header">
                        <h3 class="dashboard-card-title">Pricing Information</h3>
                    </div>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Listing Fee (5%):</span>
                            <span class="font-semibold pricing-fee">0 MAD</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Your Earnings:</span>
                            <span class="font-semibold pricing-earnings">0 MAD</span>
                        </div>
                        <div class="border-t pt-2">
                            <p class="text-xs text-gray-500">
                                The listing fee is charged only after your property is approved and published.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-3">
                    <button type="submit" name="save_draft" class="btn-primary w-full">
                        <i class="fas fa-save mr-2"></i>Save as Draft
                    </button>
                    <button type="submit" name="submit_for_review" class="btn-secondary w-full">
                        <i class="fas fa-paper-plane mr-2"></i>Submit for Review
                    </button>
                    <a href="{{ route('owner.properties.index') }}" class="btn-outline w-full text-center">
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
                    div.className = 'relative';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-24 object-cover rounded">
                        <div class="absolute top-1 left-1 bg-brand-beige text-brand-dark text-xs px-2 py-1 rounded">
                            ${index === 0 ? 'Featured' : index + 1}
                        </div>
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
</script>
@endpush
@endsection
