@extends('layouts.dashboard')

@section('title', 'Create User')
@section('page-title', 'Create New User')



@section('content')
    <div class="space-y-8">
        <div
            class="relative overflow-hidden bg-gradient-to-r from-[#2F2B40] to-[#CBA660] rounded-2xl p-8 text-white shadow-2xl">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-12 -translate-x-12"></div>

            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold mb-2">Create New User</h2>
                    <p class="text-white/80 text-lg">Add a new user to the ChriWBi3 platform with comprehensive details.</p>
                </div>
                <div class="hidden md:block">
                    <i class="fas fa-user-plus text-6xl text-[#CBA660]/30"></i>
                </div>
            </div>
        </div>

        <!-- User Form -->
        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Form -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Basic Information -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-2xl font-bold text-[#2F2B40] mb-2">Basic Information</h3>
                                    <p class="text-gray-600">Essential user details and contact information</p>
                                </div>
                                <i class="fas fa-id-card text-3xl text-[#CBA660]"></i>
                            </div>
                        </div>

                        <div class="p-8 space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-[#2F2B40] mb-2">Full Name *</label>
                                    <input type="text" name="name" value="{{ old('name') }}"
                                        placeholder="Enter full name"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#CBA660]/20 focus:border-[#CBA660] transition-all duration-200 bg-gray-50/50"
                                        required>
                                    @error('name')
                                        <p class="text-red-500 text-sm mt-1 flex items-center"><i
                                                class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-[#2F2B40] mb-2">Email Address *</label>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                        placeholder="Enter email address"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#CBA660]/20 focus:border-[#CBA660] transition-all duration-200 bg-gray-50/50"
                                        required>
                                    @error('email')
                                        <p class="text-red-500 text-sm mt-1 flex items-center"><i
                                                class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-[#2F2B40] mb-2">Phone Number</label>
                                    <input type="tel" name="phone" value="{{ old('phone') }}"
                                        placeholder="Enter phone number"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#CBA660]/20 focus:border-[#CBA660] transition-all duration-200 bg-gray-50/50">
                                    @error('phone')
                                        <p class="text-red-500 text-sm mt-1 flex items-center"><i
                                                class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-[#2F2B40] mb-2">User Role *</label>
                                    <select name="role"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#CBA660]/20 focus:border-[#CBA660] transition-all duration-200 bg-gray-50/50"
                                        required>
                                        <option value="">Select Role</option>
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="owner" {{ old('role') == 'owner' ? 'selected' : '' }}>Property
                                            Owner</option>
                                        <option value="client" {{ old('role') == 'client' ? 'selected' : '' }}>Client
                                        </option>
                                    </select>
                                    @error('role')
                                        <p class="text-red-500 text-sm mt-1 flex items-center"><i
                                                class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                    @enderror
                                    <p id="role-help" class="text-sm text-gray-500 mt-1"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Password Information -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-2xl font-bold text-[#2F2B40] mb-2">Password Information</h3>
                                    <p class="text-gray-600">Set secure login credentials for the user</p>
                                </div>
                                <i class="fas fa-lock text-3xl text-[#CBA660]"></i>
                            </div>
                        </div>

                        <div class="p-8 space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-[#2F2B40] mb-2">Password *</label>
                                    <input type="password" name="password" placeholder="Enter password"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#CBA660]/20 focus:border-[#CBA660] transition-all duration-200 bg-gray-50/50"
                                        required>
                                    @error('password')
                                        <p class="text-red-500 text-sm mt-1 flex items-center"><i
                                                class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-[#2F2B40] mb-2">Confirm Password
                                        *</label>
                                    <input type="password" name="password_confirmation" placeholder="Confirm password"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#CBA660]/20 focus:border-[#CBA660] transition-all duration-200 bg-gray-50/50"
                                        required>
                                </div>
                            </div>

                            
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-2xl font-bold text-[#2F2B40] mb-2">Additional Information</h3>
                                    <p class="text-gray-600">Optional contact details and notes</p>
                                </div>
                                <i class="fas fa-info-circle text-3xl text-[#CBA660]"></i>
                            </div>
                        </div>

                        <div class="p-8">
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-[#2F2B40] mb-2">Contact Information</label>
                                <textarea name="contact_info" rows="4" placeholder="Additional contact details, address, etc."
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#CBA660]/20 focus:border-[#CBA660] transition-all duration-200 bg-gray-50/50 resize-none">{{ old('contact_info') }}</textarea>
                                @error('contact_info')
                                    <p class="text-red-500 text-sm mt-1 flex items-center"><i
                                            class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-8">

                    <!-- User Settings -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-6 py-4 border-b border-gray-100">
                            <h3 class="text-lg font-bold text-[#2F2B40] flex items-center">
                                <i class="fas fa-cog mr-2 text-[#CBA660]"></i>User Settings
                            </h3>
                        </div>

                        <div class="p-6">
                            <div class="bg-gray-50 p-4 rounded-xl">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_active" value="1"
                                        {{ old('is_active', true) ? 'checked' : '' }}
                                        class="w-5 h-5 text-[#CBA660] border-gray-300 rounded focus:ring-[#CBA660] focus:ring-2">
                                    <span class="ml-3 text-sm font-medium text-[#2F2B40]">Account is active</span>
                                </label>
                                <p class="text-xs text-gray-500 mt-2 ml-8">
                                    <i class="fas fa-info-circle mr-1"></i>Inactive users cannot log in to the platform
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-4">
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-[#CBA660] to-[#CBA660]/80 text-white px-6 py-4 rounded-xl font-semibold shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-save mr-2"></i>Create User
                        </button>

                        <a href="{{ route('admin.users.index') }}"
                            class="block w-full text-center px-6 py-4 border border-[#CBA660] text-[#CBA660] rounded-xl hover:bg-[#CBA660] hover:text-white transition-all duration-200 font-medium shadow-sm hover:shadow-md">
                            <i class="fas fa-arrow-left mr-2"></i>Back to Users
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
