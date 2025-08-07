@extends('layouts.dashboard')

@section('title', 'Manage Properties')
@section('page-title', 'Property Management')

@section('content')
<div class="space-y-8">
    {{-- Page Header --}}
    <div class="relative overflow-hidden bg-gradient-to-r from-[#2F2B40] to-[#CBA660] rounded-2xl p-8 text-white shadow-2xl">
        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
        <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-12 -translate-x-12"></div>
        
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold mb-2">Property Management</h2>
                <p class="text-white/80 text-lg">Manage and approve property listings across the platform</p>
            </div>
            <div class="hidden md:flex items-center space-x-4">
                <button class="bg-white/20 hover:bg-white/30 text-white px-6 py-3 rounded-xl font-medium transition-all duration-200 backdrop-blur-sm">
                    <i class="fas fa-filter mr-2"></i>Filter Properties
                </button>
                <button class="bg-white/20 hover:bg-white/30 text-white px-6 py-3 rounded-xl font-medium transition-all duration-200 backdrop-blur-sm">
                    <i class="fas fa-download mr-2"></i>Export Data
                </button>
            </div>
        </div>
    </div>

    {{-- Properties Table  --}}
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold text-[#2F2B40] mb-2">All Properties</h3>
                    <p class="text-gray-600">Complete property listings management</p>
                </div>
                
                {{-- Search and Filter Form --}}
                <form method="GET" class="flex items-center space-x-3">
                    <select name="status" class="px-7 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#CBA660]/20 focus:border-[#CBA660] transition-all duration-200 bg-white text-sm" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                    <select name="type" class="px-7 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#CBA660]/20 focus:border-[#CBA660] transition-all duration-200 bg-white text-sm" onchange="this.form.submit()">
                        <option value="">All Types</option>
                        <option value="sale" {{ request('type') == 'sale' ? 'selected' : '' }}>For Sale</option>
                        <option value="rent" {{ request('type') == 'rent' ? 'selected' : '' }}>For Rent</option>
                    </select>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search properties..." 
                           class="px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#CBA660]/20 focus:border-[#CBA660] transition-all duration-200 bg-white text-sm w-64">
                    <button type="submit" class="bg-[#CBA660] hover:bg-[#CBA660]/80 text-white px-4 py-2 rounded-xl transition-all duration-200 shadow-sm hover:shadow-md">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[#2F2B40] uppercase tracking-wider">Property</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[#2F2B40] uppercase tracking-wider">Owner</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[#2F2B40] uppercase tracking-wider">Type</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[#2F2B40] uppercase tracking-wider">Price</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[#2F2B40] uppercase tracking-wider">Status</th>
                        
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[#2F2B40] uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($properties as $property)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-4">
                                    <div>
                                        <div class="font-semibold text-[#2F2B40] text-lg">{{ Str::limit($property->title, 40) }}</div>
                                        <div class="text-sm text-gray-600 flex items-center mt-1">
                                            <i class="fas fa-map-marker-alt mr-1 text-[#CBA660]"></i>
                                            {{ $property->address }}, {{ $property->city->name }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-[#2F2B40]">{{ $property->owner->name }}</div>
                                <div class="text-sm text-gray-600 flex items-center mt-1">
                                    <i class="fas fa-envelope mr-1 text-gray-400"></i>
                                    {{ $property->owner->email }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                    {{ $property->isForSale() ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                    <i class="fas {{ $property->isForSale() ? 'fa-dollar-sign' : 'fa-key' }} mr-1"></i>
                                    {{ $property->isForSale() ? 'For Sale' : 'For Rent' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-[#2F2B40] text-lg">{{ $property->formatted_price }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                                    {{ $property->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $property->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $property->status === 'draft' ? 'bg-gray-100 text-gray-800' : '' }}
                                    {{ $property->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                    <i class="fas 
                                        {{ $property->status === 'approved' ? 'fa-check-circle' : '' }}
                                        {{ $property->status === 'pending' ? 'fa-clock' : '' }}
                                        {{ $property->status === 'draft' ? 'fa-edit' : '' }}
                                        {{ $property->status === 'rejected' ? 'fa-times-circle' : '' }}
                                        mr-1"></i>
                                    {{ ucfirst($property->status) }}
                                </span>
                            </td>
                            
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('admin.properties.show', $property) }}"
                                       class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center "
                                       title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    @if($property->status === 'pending')
                                        <form action="{{ route('admin.properties.update-status', $property) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="w-8 h-8 bg-green-100 text-green-600 rounded-lg flex items-center justify-center"
                                                    onclick="return confirm('Approve this property?')"
                                                    title="Approve">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.properties.update-status', $property) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="w-8 h-8 bg-red-100 text-red-600 rounded-lg flex items-center justify-center"
                                                    onclick="return confirm('are you sure about that')"
                                                    title="Reject">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('admin.properties.destroy', $property) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 bg-red-100 text-red-600 rounded-lg flex items-center justify-center"
                                                onclick="return confirm('are you sure about that')"
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-16">
                                <div class="flex flex-col items-center justify-center text-gray-500">
                                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-building text-3xl text-gray-400"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-[#2F2B40] mb-2">No Properties Found</h3>
                                    <p class="text-gray-600">No properties match your current filters</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($properties->hasPages())
            <div class="bg-gray-50 px-8 py-6 border-t border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Showing {{ $properties->firstItem() }} to {{ $properties->lastItem() }} of {{ $properties->total() }} properties
                    </div>
                    <div class="pagination-wrapper">
                        {{ $properties->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection