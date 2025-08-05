@extends('layouts.dashboard')

@section('title', 'Edit Property - Owner Dashboard')
@section('page-title', 'Edit Property')

@section('breadcrumb')
<a href="{{ route('owner.dashboard') }}" class="hover:text-brand-dark">Dashboard</a>
<span class="mx-2">/</span>
<a href="{{ route('owner.properties.index') }}" class="hover:text-brand-dark">My Properties</a>
<span class="mx-2">/</span>
<span>Edit Property</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Property Status -->
    <div class="dashboard-card">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-full flex items-center justify-center
                    {{ $property->status === 'approved' ? 'bg-green-100 text-green-600' : '' }}
                    {{ $property->status === 'pending' ? 'bg-yellow-100 text-yellow-600' : '' }}
                    {{ $property->status === 'draft' ? 'bg-gray-100 text-gray-600' : '' }}
                    {{ $property->status === 'rejected' ? 'bg-red-100 text-red-600' : '' }}">
                    <i class="fas fa-{{ $property->status === 'approved' ? 'check' : ($property->status === 'pending' ? 'clock' : ($property->status === 'draft' ? 'edit' : 'times')) }}"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-brand-dark">Property Status: {{ ucfirst($property->status) }}</h3>
                    <p class="text-sm text-gray-600">
                        @if($property->status === 'draft')
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
            
            @if($property->status === 'draft')
                <form action="{{ route('owner.properties.update', $property) }}" method="POST" class="inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="submit_for_review" value="1">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-paper-plane mr-2"></i>Submit for Review
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Property Form -->
    <form action="{{ route('owner.properties.update', $property) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        
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
                            <input type="text" name="title" value="{{ old('title', $property->title) }}" placeholder="e.g., Beautiful 3-bedroom apartment in Casablanca" class="form-input" required>
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
                                        <option value="{{ $category->id }}" {{ old('category_id', $property->category_id) == $category->id ? 'selected' : '' }}>
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
                                    <option value="sale" {{ old('listing_type', $property->listing_type) == 'sale' ? 'selected' : '' }}>For Sale</option>
                                    <option value="rent" {{ old('listing_type', $property->listing_type) == 'rent' ? 'selected' : '' }}>For Rent</option>
                                </select>
                                @error('listing_type')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label class="form-label">Description *</label>
                            <textarea name="description" rows="4" placeholder="Describe your property in detail..." class="form-input" required>{{ old('description', $property->description) }}</textarea>
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
                                        <option value="{{ $city->id }}" {{ old('city_id', $property->city_id) == $city->id ? 'selected' : '' }}>
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
                                <input type="text" name="address" value="{{ old('address', $property->address) }}" placeholder="Full address" class="form-input" required>
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
                            <input type="number" name="bedrooms" value="{{ old('bedrooms', $property->bedrooms) }}" min="0" placeholder="0" class="form-input">
                            @error('bedrooms')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="form-label">Bathrooms</label>
                            <input type="number" name="bathrooms" value="{{ old('bathrooms', $property->bathrooms) }}" min="0" placeholder="0" class="form-input">
                            @error('bathrooms')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="form-label">Area (m²)</label>
                            <input type="number" name="area" value="{{ old('area', $property->area) }}" min="0" placeholder="0" class="form-input">
                            @error('area')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="form-label">Price (MAD) *</label>
                            <input type="number" name="price" value="{{ old('price', $property->price) }}" min="0" placeholder="0" class="form-input" required>
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
                        @php
                            $availableFeatures = ['Swimming Pool', 'Garden', 'Garage', 'Security System', 'Air Conditioning', 'Balcony', 'Parking', 'Elevator', 'Furnished'];
                            $propertyFeatures = old('features', $property->features ?? []);
                        @endphp
                        
                        @foreach($availableFeatures as $feature)
                            <label class="flex items-center">
                                <input type="checkbox" name="features[]" value="{{ $feature }}" {{ in_array($feature, $propertyFeatures) ? 'checked' : '' }} class="mr-2">
                                <span class="text-sm">{{ $feature }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Current Photos -->
                @if($property->images->count() > 0)
                    <div class="dashboard-card">
                        <div class="dashboard-card-header">
                            <h3 class="dashboard-card-title">Current Photos</h3>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-2">
                            @foreach($property->images as $image)
                                <div class="relative">
                                    <img src="{{ $image->image_url }}" alt="{{ $image->alt_text }}" class="w-full h-24 object-cover rounded">
                                    <label class="absolute top-1 right-1">
                                        <input type="checkbox" name="remove_images[]" value="{{ $image->id }}" class="sr-only">
                                        <div class="w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center text-xs cursor-pointer hover:bg-red-600">
                                            <i class="fas fa-times"></i>
                                        </div>
                                    </label>
                                    @if($image->is_featured)
                                        <div class="absolute bottom-1 left-1 bg-brand-beige text-brand-dark text-xs px-2 py-1 rounded">
                                            Featured
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        
                        <p class="text-xs text-gray-500 mt-2">
                            Check the X button to remove photos
                        </p>
                    </div>
                @endif

                <!-- Add New Photos -->
                <div class="dashboard-card">
                    <div class="dashboard-card-header">
                        <h3 class="dashboard-card-title">Add New Photos</h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                            <p class="text-sm text-gray-600 mb-2">Upload additional photos</p>
                            <input type="file" name="images[]" multiple accept="image/*" class="hidden" id="property-images">
                            <label for="property-images" class="btn-outline text-sm cursor-pointer">Choose Files</label>
                        </div>
                        
                        <div id="image-preview" class="grid grid-cols-2 gap-2 hidden"></div>
                        
                        @error('images.*')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-3">
                    <button type="submit" class="btn-primary w-full">
                        <i class="fas fa-save mr-2"></i>Update Property
                    </button>
                    
                    @if($property->status === 'draft')
                        <button type="submit" name="submit_for_review" class="btn-secondary w-full">
                            <i class="fas fa-paper-plane mr-2"></i>Update & Submit for Review
                        </button>
                    @endif
                    
                    <a href="{{ route('owner.properties.index') }}" class="btn-outline w-full text-center">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Properties
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
// Image preview functionality
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
                            New ${index + 1}
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

// Remove image functionality
document.querySelectorAll('input[name="remove_images[]"]').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const container = this.closest('.relative');
        if (this.checked) {
            container.style.opacity = '0.5';
            container.style.filter = 'grayscale(100%)';
        } else {
            container.style.opacity = '1';
            container.style.filter = 'none';
        }
    });
});
</script>
@endpush
@endsection
