@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')
@section('page-title', 'User Details')



@section('content')
    <div class="space-y-8">
        <!-- User Header Banner -->
        <div
            class="relative overflow-hidden bg-gradient-to-r from-[#2F2B40] to-[#CBA660] rounded-2xl p-8 text-white shadow-2xl">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-12 -translate-x-12"></div>

            <div class="relative z-10 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                <div class="flex items-center space-x-6">
                    <div>
                        <h1 class="text-3xl font-bold mb-3">{{ $user->name }}</h1>
                        <div class="flex flex-wrap items-center gap-4 text-white/80">
                            <span><i class="fas fa-envelope mr-2"></i>{{ $user->email }}</span>
                            @if ($user->phone)
                                <span><i class="fas fa-phone mr-2"></i>{{ $user->phone }}</span>
                            @endif
                            <span><i class="fas fa-calendar mr-2"></i>Joined
                                {{ $user->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <div class="xl:col-span-2 space-y-8">

                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-2xl font-bold text-[#2F2B40] mb-2">User Information</h3>
                                <p class="text-gray-600">Complete profile details and account information</p>
                            </div>
                            <i class="fas fa-user text-3xl text-[#CBA660]"></i>
                        </div>
                    </div>

                    <div class="p-8">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <div class="space-y-6">
                                <div class="group">
                                    <label
                                        class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2 block">Full
                                        Name</label>
                                    <div
                                        class="bg-gray-50 rounded-xl p-4 group-hover:bg-gray-100 transition-colors duration-200">
                                        <p class="text-[#2F2B40] font-semibold text-lg">{{ $user->name }}</p>
                                    </div>
                                </div>

                                <div class="group">
                                    <label
                                        class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2 block">Email
                                        Address</label>
                                    <div
                                        class="bg-gray-50 rounded-xl p-4 group-hover:bg-gray-100 transition-colors duration-200">
                                        <p class="text-[#2F2B40] font-semibold">{{ $user->email }}</p>
                                    </div>
                                </div>

                                <div class="group">
                                    <label
                                        class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2 block">Phone
                                        Number</label>
                                    <div
                                        class="bg-gray-50 rounded-xl p-4 group-hover:bg-gray-100 transition-colors duration-200">
                                        <p class="text-[#2F2B40] font-semibold">{{ $user->phone ?: 'Not provided' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-6">
                                <div class="group">
                                    <label
                                        class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2 block">User
                                        Role</label>
                                    <div
                                        class="bg-gray-50 rounded-xl p-4 group-hover:bg-gray-100 transition-colors duration-200">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-md font-semibold">
                                            {{ $user->role }}
                                        </span>
                                    </div>
                                </div>

                                <div class="group">
                                    <label
                                        class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2 block">Account
                                        Status</label>
                                    <div
                                        class="bg-gray-50 rounded-xl p-4 group-hover:bg-gray-100 transition-colors duration-200">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                                        {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">

                                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                       
                    </div>
                </div>

            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Quick Actions -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-6 py-4 border-b border-gray-100">
                        <h3 class="text-xl font-bold text-[#2F2B40] flex items-center">
                            <i class="fas fa-bolt text-[#CBA660] mr-2"></i>
                            Quick Actions
                        </h3>
                    </div>

                    <div class="p-6 space-y-4">
                        <a href="{{ route('admin.users.edit', $user) }}"
                            class="group relative w-full bg-gradient-to-r from-[#CBA660] to-[#CBA660]/80 text-white p-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 block text-center">
                            <div
                                class="absolute top-0 right-0 w-16 h-16 bg-white/10 rounded-full -translate-y-8 translate-x-8">
                            </div>
                            <div class="relative z-10 flex items-center justify-center">
                                <i class="fas fa-edit mr-2"></i>Edit User
                            </div>
                        </a>

                        @if ($user->id !== Auth::id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="w-full">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="group relative w-full bg-gradient-to-r from-red-500 to-red-600 text-white p-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105"
                                    onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                    <div
                                        class="absolute top-0 right-0 w-16 h-16 bg-white/10 rounded-full -translate-y-8 translate-x-8">
                                    </div>
                                    <div class="relative z-10 flex items-center justify-center">
                                        <i class="fas fa-trash mr-2"></i>Delete User
                                    </div>
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('admin.users.index') }}"
                            class="group relative w-full bg-gradient-to-r from-gray-500 to-gray-600 text-white p-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 block text-center">
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
        </div>
    </div>


@endsection
