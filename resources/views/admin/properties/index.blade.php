@extends('layouts.dashboard')

@section('title', 'Manage Properties - Admin Dashboard')
@section('page-title', 'Property Management')

@section('breadcrumb')
<a href="{{ route('admin.dashboard') }}" class="hover:text-brand-dark">Dashboard</a>
<span class="mx-2">/</span>
<span>Properties</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex justify-between items-center">
        <div>
            <p class="text-gray-600">Manage and approve property listings</p>
        </div>
        <div class="flex space-x-3">
            <button class="btn-outline">
                <i class="fas fa-filter mr-2"></i>Filter Properties
            </button>
            <button class="btn-outline">
                <i class="fas fa-download mr-2"></i>Export Data
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="dashboard-stat">
            <div class="flex items-center justify-between">
                <div>
                    <div class="dashboard-stat-value">{{ $stats['total'] }}</div>
                    <div class="dashboard-stat-label">Total Properties</div>
                </div>
                <div class="text-blue-500">
                    <i class="fas fa-building text-3xl"></i>
                </div>
            </div>
        </div>

        <div class="dashboard-stat">
            <div class="flex items-center justify-between">
                <div>
                    <div class="dashboard-stat-value">{{ $stats['pending'] }}</div>
                    <div class="dashboard-stat-label">Pending Approval</div>
                </div>
                <div class="text-yellow-500">
                    <i class="fas fa-clock text-3xl"></i>
                </div>
            </div>
        </div>

        <div class="dashboard-stat">
            <div class="flex items-center justify-between">
                <div>
                    <div class="dashboard-stat-value">{{ $stats['approved'] }}</div>
                    <div class="dashboard-stat-label">Published</div>
                </div>
                <div class="text-green-500">
                    <i class="fas fa-check-circle text-3xl"></i>
                </div>
            </div>
        </div>

        <div class="dashboard-stat">
            <div class="flex items-center justify-between">
                <div>
                    <div class="dashboard-stat-value">{{ $stats['rejected'] }}</div>
                    <div class="dashboard-stat-label">Rejected</div>
                </div>
                <div class="text-red-500">
                    <i class="fas fa-times-circle text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Properties Table -->
    <div class="dashboard-card">
        <div class="dashboard-card-header">
            <h3 class="dashboard-card-title">All Properties</h3>
            <form method="GET" class="flex space-x-2">
                <select name="status" class="form-input text-sm" onchange="this.form.submit()">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
                <select name="type" class="form-input text-sm" onchange="this.form.submit()">
                    <option value="">All Types</option>
                    <option value="sale" {{ request('type') == 'sale' ? 'selected' : '' }}>For Sale</option>
                    <option value="rent" {{ request('type') == 'rent' ? 'selected' : '' }}>For Rent</option>
                </select>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search properties..." class="form-input text-sm">
                <button type="submit" class="btn-outline text-sm">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
        
        <div class="overflow-x-auto">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Property</th>
                        <th>Owner</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Submitted</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($properties as $property)
                        <tr>
                            <td>
                                <div class="flex items-center space-x-3">
                                    <img src="{{ $property->featured_image_url }}"
                                         alt="{{ $property->title }}"
                                         class="w-12 h-12 object-cover rounded">
                                    <div>
                                        <div class="font-semibold text-brand-dark">{{ Str::limit($property->title, 40) }}</div>
                                        <div class="text-sm text-gray-600">{{ $property->address }}, {{ $property->city->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="font-semibold">{{ $property->owner->name }}</div>
                                <div class="text-sm text-gray-600">{{ $property->owner->email }}</div>
                            </td>
                            <td>
                                <span class="property-status {{ $property->isForSale() ? 'status-sale' : 'status-rent' }}">
                                    {{ $property->isForSale() ? 'For Sale' : 'For Rent' }}
                                </span>
                                <div class="text-sm text-gray-600">{{ $property->category->name }}</div>
                            </td>
                            <td>
                                <div class="font-semibold">{{ $property->formatted_price }}</div>
                            </td>
                            <td>
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    {{ $property->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $property->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $property->status === 'draft' ? 'bg-gray-100 text-gray-800' : '' }}
                                    {{ $property->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($property->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="text-sm">{{ $property->created_at->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $property->created_at->diffForHumans() }}</div>
                            </td>
                            <td>
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.properties.show', $property) }}"
                                       class="text-blue-600 hover:text-blue-800 text-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    @if($property->status === 'pending')
                                        <form action="{{ route('admin.properties.update-status', $property) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="text-green-600 hover:text-green-800 text-sm"
                                                    onclick="return confirm('Approve this property?')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.properties.update-status', $property) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm"
                                                    onclick="return confirm('Reject this property?')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('admin.properties.destroy', $property) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm"
                                                onclick="return confirm('Delete this property permanently?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-8 text-gray-500">
                                <i class="fas fa-building text-4xl mb-3 block"></i>
                                No properties found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($properties->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $properties->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
