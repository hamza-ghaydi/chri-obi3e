@extends('layouts.dashboard')

@section('title', 'Create User - Admin Dashboard')
@section('page-title', 'Create New User')

@section('breadcrumb')
<a href="{{ route('admin.dashboard') }}" class="hover:text-brand-dark">Dashboard</a>
<span class="mx-2">/</span>
<a href="{{ route('admin.users.index') }}" class="hover:text-brand-dark">Users</a>
<span class="mx-2">/</span>
<span>Create User</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- User Form -->
    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
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
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="form-label">Full Name *</label>
                                <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter full name" class="form-input" required>
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="form-label">Email Address *</label>
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter email address" class="form-input" required>
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="form-label">Phone Number</label>
                                <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="Enter phone number" class="form-input">
                                @error('phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="form-label">User Role *</label>
                                <select name="role" class="form-input" required>
                                    <option value="">Select Role</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="owner" {{ old('role') == 'owner' ? 'selected' : '' }}>Property Owner</option>
                                    <option value="client" {{ old('role') == 'client' ? 'selected' : '' }}>Client</option>
                                </select>
                                @error('role')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Password Information -->
                <div class="dashboard-card">
                    <div class="dashboard-card-header">
                        <h3 class="dashboard-card-title">Password Information</h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="form-label">Password *</label>
                                <input type="password" name="password" placeholder="Enter password" class="form-input" required>
                                @error('password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="form-label">Confirm Password *</label>
                                <input type="password" name="password_confirmation" placeholder="Confirm password" class="form-input" required>
                            </div>
                        </div>
                        
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-900 mb-2">Password Requirements:</h4>
                            <ul class="text-sm text-blue-700 space-y-1">
                                <li>• Minimum 8 characters</li>
                                <li>• Mix of uppercase and lowercase letters recommended</li>
                                <li>• Include numbers and special characters for better security</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="dashboard-card">
                    <div class="dashboard-card-header">
                        <h3 class="dashboard-card-title">Additional Information</h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="form-label">Contact Information</label>
                            <textarea name="contact_info" rows="3" placeholder="Additional contact details, address, etc." class="form-input">{{ old('contact_info') }}</textarea>
                            @error('contact_info')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Profile Picture -->
                <div class="dashboard-card">
                    <div class="dashboard-card-header">
                        <h3 class="dashboard-card-title">Profile Picture</h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="text-center">
                            <div id="image-preview" class="w-32 h-32 mx-auto bg-gray-200 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-user text-4xl text-gray-400"></i>
                            </div>
                            
                            <input type="file" name="profile_picture" accept="image/*" class="hidden" id="profile-picture">
                            <label for="profile-picture" class="btn-outline cursor-pointer">
                                <i class="fas fa-upload mr-2"></i>Upload Photo
                            </label>
                        </div>
                        
                        <p class="text-xs text-gray-500 text-center">
                            Recommended: Square image, max 2MB
                        </p>
                        
                        @error('profile_picture')
                            <p class="text-red-500 text-sm text-center">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- User Settings -->
                <div class="dashboard-card">
                    <div class="dashboard-card-header">
                        <h3 class="dashboard-card-title">User Settings</h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="mr-2">
                                <span class="text-sm">Account is active</span>
                            </label>
                            <p class="text-xs text-gray-500 mt-1">Inactive users cannot log in to the platform</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-3">
                    <button type="submit" class="btn-primary w-full">
                        <i class="fas fa-save mr-2"></i>Create User
                    </button>
                    
                    <a href="{{ route('admin.users.index') }}" class="btn-outline w-full text-center">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Users
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
// Profile picture preview
document.getElementById('profile-picture').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('image-preview');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" class="w-32 h-32 rounded-full object-cover">`;
        };
        reader.readAsDataURL(file);
    } else {
        preview.innerHTML = '<i class="fas fa-user text-4xl text-gray-400"></i>';
    }
});

// Role-based help text
document.querySelector('select[name="role"]').addEventListener('change', function() {
    const roleHelp = document.getElementById('role-help');
    const role = this.value;
    
    let helpText = '';
    switch(role) {
        case 'admin':
            helpText = 'Admins have full access to manage the platform, users, and properties.';
            break;
        case 'owner':
            helpText = 'Property owners can list and manage their properties, handle appointments.';
            break;
        case 'client':
            helpText = 'Clients can browse properties, save favorites, and book appointments.';
            break;
    }
    
    if (roleHelp) {
        roleHelp.textContent = helpText;
    }
});
</script>
@endpush
@endsection
