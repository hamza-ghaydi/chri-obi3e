@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')
@section('page-title', 'Edit User')



@section('content')
    <div class="space-y-8 overflow-hidden">

        <div
            class="relative overflow-hidden bg-gradient-to-r from-[#2F2B40] to-[#CBA660] rounded-2xl p-8 text-white shadow-2xl">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-12 -translate-x-12"></div>

            <div class="relative z-10 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                <div class="flex items-center space-x-6">

                    <div>
                        <h2 class="text-3xl font-bold mb-2">Edit User Profile</h2>
                        <p class="text-white/80 text-lg">Updating {{ $user->name }}'s account information</p>
                    </div>
                </div>
                <div class="hidden md:block">
                    <i class="fas fa-user-edit text-6xl text-[#CBA660]/30"></i>
                </div>
            </div>
        </div>


        <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data"
            class="space-y-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                <div class="xl:col-span-2 space-y-8">
                    {{-- Basic Information --}}
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-2xl font-bold text-[#2F2B40] mb-2">Basic Information</h3>
                                    <p class="text-gray-600">Essential user account details</p>
                                </div>
                                <i class="fas fa-user text-3xl text-[#CBA660]"></i>
                            </div>
                        </div>

                        <div class="p-8 space-y-6">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <div class="group">
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">Full Name *</label>
                                    <div class="relative">
                                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                            placeholder="Enter full name"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-[#CBA660] focus:ring-[#CBA660] focus:ring-opacity-20 transition-all duration-200 group-hover:border-gray-300"
                                            required>
                                        <i
                                            class="fas fa-user absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    </div>

                                </div>

                                <div class="group">
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">Email Address *</label>
                                    <div class="relative">
                                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                            placeholder="Enter email address"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-[#CBA660] focus:ring-[#CBA660] focus:ring-opacity-20 transition-all duration-200 group-hover:border-gray-300"
                                            required>
                                        <i
                                            class="fas fa-envelope absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    </div>

                                </div>
                            </div>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <div class="group">
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">Phone Number</label>
                                    <div class="relative">
                                        <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}"
                                            placeholder="Enter phone number"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-[#CBA660] focus:ring-[#CBA660] focus:ring-opacity-20 transition-all duration-200 group-hover:border-gray-300">
                                        <i
                                            class="fas fa-phone absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    </div>

                                </div>

                                <div class="group">
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">User Role *</label>
                                    <div class="relative">
                                        <select name="role"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-[#CBA660] focus:ring-[#CBA660] focus:ring-opacity-20 transition-all duration-200 group-hover:border-gray-300 appearance-none bg-white"
                                            required>
                                            <option value="">Select Role</option>
                                            <option value="admin"
                                                {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="owner"
                                                {{ old('role', $user->role) == 'owner' ? 'selected' : '' }}>Property Owner
                                            </option>
                                            <option value="client"
                                                {{ old('role', $user->role) == 'client' ? 'selected' : '' }}>Client
                                            </option>
                                        </select>
                                        <i
                                            class="fas fa-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Password Information --}}
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-2xl font-bold text-[#2F2B40] mb-2">Password Information</h3>
                                    <p class="text-gray-600">Update user password securely</p>
                                </div>
                                <i class="fas fa-lock text-3xl text-[#CBA660]"></i>
                            </div>
                        </div>

                        <div class="p-8 space-y-6">

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <div class="group">
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">New Password</label>
                                    <div class="relative">
                                        <input type="password" name="password" placeholder="Enter new password"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-[#CBA660] focus:ring-[#CBA660] focus:ring-opacity-20 transition-all duration-200 group-hover:border-gray-300">
                                        <i
                                            class="fas fa-key absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    </div>
                                    @error('password')
                                        <p class="text-red-500 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="group">
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">Confirm New
                                        Password</label>
                                    <div class="relative">
                                        <input type="password" name="password_confirmation"
                                            placeholder="Confirm new password"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-[#CBA660] focus:ring-[#CBA660] focus:ring-opacity-20 transition-all duration-200 group-hover:border-gray-300">
                                        <i
                                            class="fas fa-check-circle absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-8">
                    

                    <!-- User Settings -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-6 py-4 border-b border-gray-100">
                            <h3 class="text-xl font-bold text-[#2F2B40] flex items-center">
                                <i class="fas fa-cog text-[#CBA660] mr-2"></i>
                                User Settings
                            </h3>
                        </div>

                        <div class="p-6 space-y-6">
                            <div class="group">
                                <label
                                    class="flex items-center p-4 bg-gray-50 rounded-xl cursor-pointer hover:bg-gray-100 transition-colors duration-200">
                                    <input type="checkbox" name="is_active" value="1"
                                        {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                                        class="w-5 h-5 text-[#CBA660] border-gray-300 rounded focus:ring-[#CBA660] mr-4">
                                    <div>
                                        <span class="font-semibold text-gray-900">Account is active</span>
                                        <p class="text-sm text-gray-600 mt-1">Allow user to log in to the platform</p>
                                    </div>
                                </label>
                            </div>

                            @if ($user->id === Auth::id())
                                <div
                                    class="bg-gradient-to-r from-red-50 to-red-100/50 border border-red-200 rounded-xl p-4">
                                    <div class="flex items-start space-x-3">
                                        <div
                                            class="w-8 h-8 bg-red-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-exclamation-triangle text-white text-sm"></i>
                                        </div>
                                        <div>
                                            <h5 class="font-semibold text-red-800 text-sm">Self-Edit Warning</h5>
                                            <p class="text-xs text-red-700 mt-1">You are editing your own account. Be
                                                careful with role and status changes.</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-4">
                        <button type="submit"
                            class="group relative w-full bg-gradient-to-r from-[#CBA660] to-[#CBA660]/80 text-white p-4 rounded-xl shadow-lg hover:shadow-xl">
                            <div
                                class="absolute top-0 right-0 w-16 h-16 bg-white/10 rounded-full -translate-y-8 translate-x-8">
                            </div>
                            <div class="relative z-10 flex items-center justify-center">
                                <i class="fas fa-save mr-2"></i>Update User
                            </div>
                        </button>

                        <a href="{{ route('admin.users.show', $user) }}"
                            class="group relative w-full bg-gradient-to-r border-[#CBA660] border text-[#CBA660] p-4 rounded-xl shadow-lg hover:shadow-xl block text-center">
                            <div
                                class="absolute top-0 right-0 w-16 h-16 bg-white/10 rounded-full -translate-y-8 translate-x-8">
                            </div>
                            <div class="relative z-10 flex items-center justify-center">
                                <i class="fas fa-eye mr-2"></i>View User Details
                            </div>
                        </a>

                        <a href="{{ route('admin.users.index') }}"
                            class="group relative w-full bg-gradient-to-r from-gray-500 to-gray-600 text-white p-4 rounded-xl shadow-lg hover:shadow-xl block text-center">
                            <div
                                class="absolute top-0 right-0 w-16 h-16 bg-white/10 rounded-full -translate-y-8 translate-x-8">
                            </div>
                            <div class="relative z-10 flex items-center justify-center">
                                <i class="fas fa-arrow-left mr-2"></i>Back to Users
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
