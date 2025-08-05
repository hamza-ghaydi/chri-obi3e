@extends('layouts.dashboard')

@section('title', 'Manage Categories - Admin Dashboard')
@section('page-title', 'Category Management')

@section('breadcrumb')
<a href="{{ route('admin.dashboard') }}" class="hover:text-brand-dark">Dashboard</a>
<span class="mx-2">/</span>
<span>Categories</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="dashboard-stat">
            <div class="flex items-center justify-between">
                <div>
                    <div class="dashboard-stat-value">{{ $stats['total'] }}</div>
                    <div class="dashboard-stat-label">Total Categories</div>
                </div>
                <div class="text-blue-500">
                    <i class="fas fa-tags text-3xl"></i>
                </div>
            </div>
        </div>

        <div class="dashboard-stat">
            <div class="flex items-center justify-between">
                <div>
                    <div class="dashboard-stat-value">{{ $stats['active'] }}</div>
                    <div class="dashboard-stat-label">Active</div>
                </div>
                <div class="text-green-500">
                    <i class="fas fa-check-circle text-3xl"></i>
                </div>
            </div>
        </div>

        <div class="dashboard-stat">
            <div class="flex items-center justify-between">
                <div>
                    <div class="dashboard-stat-value">{{ $stats['inactive'] }}</div>
                    <div class="dashboard-stat-label">Inactive</div>
                </div>
                <div class="text-red-500">
                    <i class="fas fa-times-circle text-3xl"></i>
                </div>
            </div>
        </div>

        <div class="dashboard-stat">
            <div class="flex items-center justify-between">
                <div>
                    <div class="dashboard-stat-value">{{ $stats['with_properties'] }}</div>
                    <div class="dashboard-stat-label">With Properties</div>
                </div>
                <div class="text-purple-500">
                    <i class="fas fa-home text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Add/Edit Category Form -->
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <h3 class="dashboard-card-title" id="form-title">Add New Category</h3>
            </div>

            <form id="category-form" action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" id="category-id" name="_method" value="">

                <div>
                    <label class="form-label">Category Name *</label>
                    <input type="text" id="category-name" name="name" value="{{ old('name') }}" placeholder="e.g., Apartment" class="form-input" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="form-label">Icon Class</label>
                    <input type="text" id="category-icon" name="icon" value="{{ old('icon') }}" placeholder="fas fa-building" class="form-input">
                    <p class="text-xs text-gray-500 mt-1">FontAwesome icon class (e.g., fas fa-building)</p>
                    @error('icon')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="form-label">Description</label>
                    <textarea id="category-description" name="description" rows="3" placeholder="Category description..." class="form-input">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="flex items-center">
                        <input type="checkbox" id="category-active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="mr-2">
                        <span class="text-sm">Active</span>
                    </label>
                </div>

                <div class="flex space-x-2">
                    <button type="submit" class="btn-primary flex-1">
                        <i class="fas fa-save mr-2"></i><span id="submit-text">Save Category</span>
                    </button>
                    <button type="button" id="cancel-edit" class="btn-outline" onclick="resetForm()">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </button>
                </div>
            </form>
        </div>

        <!-- Categories List -->
        <div class="lg:col-span-2">
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <h3 class="dashboard-card-title">All Categories</h3>
                    <form method="GET" class="flex space-x-2">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search categories..." class="form-input text-sm">
                        <select name="status" class="form-input text-sm" onchange="this.form.submit()">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        <button type="submit" class="btn-outline text-sm">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>

                <div class="space-y-3">
                    @forelse($categories as $category)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-brand-beige rounded-lg flex items-center justify-center">
                                    @if($category->icon)
                                        <i class="{{ $category->icon }} text-brand-dark"></i>
                                    @else
                                        <i class="fas fa-tag text-brand-dark"></i>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-semibold text-brand-dark">{{ $category->name }}</h4>
                                    @if($category->description)
                                        <p class="text-sm text-gray-600">{{ Str::limit($category->description, 60) }}</p>
                                    @endif
                                    <p class="text-xs text-gray-500">Slug: {{ $category->slug }} • {{ $category->properties_count }} properties</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button onclick="toggleCategoryStatus({{ $category->id }})"
                                        class="px-2 py-1 rounded-full text-xs font-semibold cursor-pointer
                                        {{ $category->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                </button>
                                <button onclick="editCategory({{ $category->id }})" class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-edit"></i>
                                </button>
                                @if($category->properties_count == 0)
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800"
                                                onclick="return confirm('Are you sure you want to delete this category?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400" title="Cannot delete category with properties">
                                        <i class="fas fa-trash"></i>
                                    </span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-tags text-4xl mb-3 block"></i>
                            <p>No categories found</p>
                        </div>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Toggle category status
function toggleCategoryStatus(categoryId) {
    fetch(`/admin/categories/${categoryId}/toggle-status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error updating category status');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating category status');
    });
}

// Edit category
function editCategory(categoryId) {
    fetch(`/admin/categories/${categoryId}/edit`)
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const category = data.category;

            // Update form
            document.getElementById('form-title').textContent = 'Edit Category';
            document.getElementById('category-form').action = `/admin/categories/${categoryId}`;
            document.querySelector('input[name="_method"]').value = 'PUT';
            document.getElementById('category-name').value = category.name;
            document.getElementById('category-icon').value = category.icon || '';
            document.getElementById('category-description').value = category.description || '';
            document.getElementById('category-active').checked = category.is_active;
            document.getElementById('submit-text').textContent = 'Update Category';

            // Scroll to form
            document.getElementById('category-form').scrollIntoView({ behavior: 'smooth' });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error loading category data');
    });
}

// Reset form
function resetForm() {
    document.getElementById('form-title').textContent = 'Add New Category';
    document.getElementById('category-form').action = '{{ route("admin.categories.store") }}';
    document.querySelector('input[name="_method"]').value = '';
    document.getElementById('category-form').reset();
    document.getElementById('submit-text').textContent = 'Save Category';
    document.getElementById('category-active').checked = true;
}

// Auto-generate slug from name
document.getElementById('category-name').addEventListener('input', function() {
    // This is handled server-side, but we could add client-side preview here
});
</script>
@endpush
@endsection
