@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')
@section('page-title', 'User Management')



@section('content')
    <div class="space-y-8">
        
        <div
            class="relative overflow-hidden bg-gradient-to-r from-[#2F2B40] to-[#CBA660] rounded-2xl p-8 text-white shadow-2xl">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-12 -translate-x-12"></div>

            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold mb-2">User Management</h2>
                    <p class="text-white/80 text-lg">Manage all platform users and their permissions</p>
                </div>
                <div class="hidden md:block">
                    <i class="fas fa-users text-6xl text-[#CBA660]/30"></i>
                </div>
            </div>
        </div>

        <!-- Header Actions -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <div>
                    <h3 class="text-xl font-bold text-[#2F2B40] mb-1">Platform Users</h3>
                    <p class="text-gray-600">Comprehensive user management and control</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <button id="bulk-actions-btn"
                        class="group relative hidden bg-gradient-to-r from-purple-500 to-purple-600 text-white px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <div class="absolute top-0 right-0 w-16 h-16 bg-white/10 rounded-full -translate-y-8 translate-x-8">
                        </div>
                        <div class="relative z-10 flex items-center">
                            <i class="fas fa-tasks mr-2"></i>Bulk Actions
                        </div>
                    </button>
                    <a href="{{ route('admin.users.create') }}"
                        class="group relative bg-gradient-to-r from-[#CBA660] to-[#CBA660]/80 text-white px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <div class="absolute top-0 right-0 w-16 h-16 bg-white/10 rounded-full -translate-y-8 translate-x-8">
                        </div>
                        <div class="relative z-10 flex items-center">
                            <i class="fas fa-plus mr-2"></i>Add New User
                        </div>
                    </a>
                </div>
            </div>
        </div>

        {{-- Users Table --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-2xl font-bold text-[#2F2B40] mb-2">All Users</h3>
                        <p class="text-gray-600">Comprehensive list of all platform users</p>
                    </div>
                    {{-- search and Filtre --}}
                    <form method="GET" class="flex flex-wrap gap-3">
                        <select name="role"
                            class="px-8 py-2 rounded-xl border border-gray-200 focus:border-[#CBA660] focus:ring-[#CBA660] "
                            onchange="this.form.submit()">
                            <option value="">All Roles</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="owner" {{ request('role') == 'owner' ? 'selected' : '' }}>Owner</option>
                            <option value="client" {{ request('role') == 'client' ? 'selected' : '' }}>Client</option>
                        </select>
                        <select name="status"
                            class="px-8 py-2 rounded-xl border border-gray-200 focus:border-[#CBA660] focus:ring-[#CBA660] focus:ring-opacity-20 transition-all duration-200"
                            onchange="this.form.submit()">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive
                            </option>
                        </select>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search users..."
                            class="px-4 py-2 rounded-xl border border-gray-200 focus:border-[#CBA660] focus:ring-[#CBA660] focus:ring-opacity-20 transition-all duration-200">
                        <button type="submit"
                            class="px-4 py-2 bg-[#CBA660] text-white rounded-xl hover:bg-[#CBA660]/80 transition-all duration-200">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                User</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Role</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Email</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Phone</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Status</th>
                            
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-4">
                                        <div>
                                            <div class="font-semibold text-[#2F2B40] text-lg">{{ $user->name }}</div>
                                            <div class="text-sm text-gray-500">ID: {{ $user->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-start py-1 font-semibold">
                                        {{($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-medium text-[#2F2B40]">{{ $user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $user->phone ?: 'Not provided' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold">
                                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex space-x-3">
                                        <a href="{{ route('admin.users.show', $user) }}"
                                            class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center "
                                            title="View User">
                                            <i class="fas fa-eye text-sm"></i>
                                        </a>

                                        <a href="{{ route('admin.users.edit', $user) }}"
                                            class="w-8 h-8 bg-green-100 text-green-600 rounded-lg flex items-center justify-center"
                                            title="Edit User">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>

                                        @if ($user->id !== Auth::id())
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="w-8 h-8 bg-red-100 text-red-600 rounded-lg flex items-center justify-center"
                                                    title="Delete User"
                                                    onclick="return confirm('are you sure about that')">
                                                    <i class="fas fa-trash text-sm"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                    
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">No users found</h3>
                                    
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($users->hasPages())
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    {{ $users->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>

    
@endsection
