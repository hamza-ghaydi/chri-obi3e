@extends('layouts.dashboard')

@section('title', 'Manage Categories - Admin Dashboard')
@section('page-title', 'Category Management')


@section('content')
    <div class="space-y-8">
        
        <div
            class="relative overflow-hidden bg-gradient-to-r from-[#2F2B40] to-[#CBA660] rounded-2xl p-8 text-white shadow-2xl">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-12 -translate-x-12"></div>

            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold mb-2">Category Management</h2>
                    <p class="text-white/80 text-lg">Organize and manage property categories for ChriWBi3 platform.</p>
                </div>
                <div class="hidden md:block">
                    <i class="fas fa-tags text-6xl text-[#CBA660]/30"></i>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Add/Edit Category Form  --}}
            <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold text-[#2F2B40] mb-2" id="form-title">Add New Category</h3>
                            <p class="text-gray-600">Create and manage property categories</p>
                        </div>
                        <i class="fas fa-plus text-3xl text-[#CBA660]"></i>
                    </div>
                </div>

                <div class="p-8">
                    <form id="category-form" action="{{ route('admin.categories.store') }}" method="POST"
                        class="space-y-6">
                        @csrf
                        <input type="hidden" id="category-id" name="_method" value="">

                        <div>
                            <label class="block text-sm font-semibold text-[#2F2B40] mb-2">Category Name *</label>
                            <input type="text" id="category-name" name="name" value="{{ old('name') }}"
                                placeholder="e.g., Apartment"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#CBA660] focus:ring-2 focus:ring-[#CBA660]/20 transition-all duration-300 outline-none"
                                required>
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-[#2F2B40] mb-2">Icon Class</label>
                            <input type="text" id="category-icon" name="icon" value="{{ old('icon') }}"
                                placeholder="fas fa-building"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#CBA660] focus:ring-2 focus:ring-[#CBA660]/20 transition-all duration-300 outline-none">
                            <p class="text-xs text-gray-500 mt-1">FontAwesome icon class (e.g., fas fa-building)</p>
                            @error('icon')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-[#2F2B40] mb-2">Description</label>
                            <textarea id="category-description" name="description" rows="3" placeholder="Category description..."
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#CBA660] focus:ring-2 focus:ring-[#CBA660]/20 transition-all duration-300 outline-none resize-none">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" id="category-active" name="is_active" value="1"
                                    {{ old('is_active', true) ? 'checked' : '' }} class="sr-only">
                                <div class="relative">
                                    <div
                                        class="w-10 h-6 bg-gray-200 rounded-full shadow-inner transition-colors duration-300 category-toggle-bg">
                                    </div>
                                    <div
                                        class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full shadow transition-transform duration-300 category-toggle-dot">
                                    </div>
                                </div>
                                <span class="ml-3 text-sm font-medium text-[#2F2B40]">Active</span>
                            </label>
                        </div>

                        <div class="flex space-x-3">
                            <button type="submit"
                                class="flex-1 bg-gradient-to-r from-[#CBA660] to-[#CBA660]/80 text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                                <i class="fas fa-save mr-2"></i><span id="submit-text">Save Category</span>
                            </button>
                            <button type="button" id="cancel-edit"
                                class="bg-white border border-[#CBA660] text-[#CBA660] font-semibold py-3 px-6 rounded-xl hover:bg-[#CBA660]/5 transition-all duration-300"
                                onclick="resetForm()">
                                <i class="fas fa-times mr-2"></i>Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Categories List --}}
            <div class="lg:col-span-2">
                <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-[#2F2B40]/5 to-[#CBA660]/5 px-8 py-6 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-2xl font-bold text-[#2F2B40] mb-2">All Categories</h3>
                                <p class="text-gray-600">Manage existing categories</p>
                            </div>
                            <form method="GET" class="flex space-x-3">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Search categories..."
                                    class="px-4 py-2 rounded-lg border border-gray-200 focus:border-[#CBA660] focus:ring-2 focus:ring-[#CBA660]/20 transition-all duration-300 outline-none text-sm">
                                <select name="status"
                                    class="px-7 py-2 rounded-lg border border-gray-200 focus:border-[#CBA660] focus:ring-2 focus:ring-[#CBA660]/20 transition-all duration-300 outline-none text-sm"
                                    onchange="this.form.submit()">
                                    <option value="">All Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                                        Inactive</option>
                                </select>
                                <button type="submit"
                                    class="bg-[#CBA660] text-white px-4 py-2 rounded-lg hover:bg-[#CBA660]/80 transition-all duration-300">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="p-8 space-y-4">
                        @forelse($categories as $category)
                            <div
                                class="group relative bg-gradient-to-r from-gray-50 to-gray-50/50 rounded-xl p-6 border border-gray-100 hover:shadow-lg transition-all duration-300 hover:border-[#CBA660]/30">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="relative">
                                            <div
                                                class="w-14 h-14 bg-gradient-to-br from-[#CBA660]/20 to-[#CBA660]/40 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                                @if ($category->icon)
                                                    <i class="{{ $category->icon }} text-[#CBA660] text-xl"></i>
                                                @else
                                                    <i class="fas fa-tag text-[#CBA660] text-xl"></i>
                                                @endif
                                            </div>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-[#2F2B40] text-lg">{{ $category->name }}</h4>
                                            @if ($category->description)
                                                <p class="text-sm text-gray-600 mb-1">
                                                    {{ Str::limit($category->description, 60) }}</p>
                                            @endif
                                            <div class="flex items-center space-x-2 text-xs text-gray-500">
                                                <span
                                                    class="bg-gray-200 px-2 py-1 rounded-full">{{ $category->slug }}</span>
                                                <span
                                                    class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full">{{ $category->properties_count }}
                                                    properties</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <button onclick="toggleCategoryStatus({{ $category->id }})"
                                            class="px-4 py-2 rounded-full text-xs font-semibold cursor-pointer transition-all duration-300 transform hover:scale-105
                                            {{ $category->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                                        </button>
                                        <button onclick="editCategory({{ $category->id }})"
                                            class="w-10 h-10 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 hover:scale-110 transition-all duration-300 flex items-center justify-center">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        @if ($category->properties_count == 0)
                                            <form action="{{ route('admin.categories.destroy', $category) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="w-10 h-10 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 hover:scale-110 transition-all duration-300 flex items-center justify-center"
                                                    onclick="return confirm('Are you sure you want to delete this category?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <div class="w-10 h-10 bg-gray-100 text-gray-400 rounded-lg flex items-center justify-center cursor-not-allowed"
                                                title="Cannot delete category with properties">
                                                <i class="fas fa-trash"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-16">
                                <div
                                    class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <i class="fas fa-tags text-4xl text-gray-400"></i>
                                </div>
                                <h3 class="text-xl font-semibold text-[#2F2B40] mb-2">No categories found</h3>
                                <p class="text-gray-500">Start by creating your first property category</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Custom checkbox styling
            document.addEventListener('DOMContentLoaded', function() {
                const checkbox = document.getElementById('category-active');
                const toggleBg = document.querySelector('.category-toggle-bg');
                const toggleDot = document.querySelector('.category-toggle-dot');

                function updateToggle() {
                    if (checkbox.checked) {
                        toggleBg.classList.add('bg-[#CBA660]');
                        toggleBg.classList.remove('bg-gray-200');
                        toggleDot.classList.add('translate-x-4');
                    } else {
                        toggleBg.classList.remove('bg-[#CBA660]');
                        toggleBg.classList.add('bg-gray-200');
                        toggleDot.classList.remove('translate-x-4');
                    }
                }

                updateToggle();
                checkbox.addEventListener('change', updateToggle);
            });

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

                            // Update toggle appearance
                            const event = new Event('change');
                            document.getElementById('category-active').dispatchEvent(event);

                            // Scroll to form
                            document.getElementById('category-form').scrollIntoView({
                                behavior: 'smooth'
                            });
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
                document.getElementById('category-form').action = '{{ route('admin.categories.store') }}';
                document.querySelector('input[name="_method"]').value = '';
                document.getElementById('category-form').reset();
                document.getElementById('submit-text').textContent = 'Save Category';
                document.getElementById('category-active').checked = true;

                // Update toggle appearance
                const event = new Event('change');
                document.getElementById('category-active').dispatchEvent(event);
            }
        </script>
    @endpush
@endsection
