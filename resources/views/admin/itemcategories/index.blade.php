@extends('template')
@section('title', 'Item Categories Management')
@section('content')
<div class="container mx-auto p-4">
    @if(session('error'))
        <div 
            id="error-alert"
            class="fixed bottom-5 right-5 z-50 flex items-center gap-3 bg-red-500 text-white px-5 py-3 rounded-xl shadow-lg transition-all duration-300"
        >
            <!-- Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" 
                class="h-5 w-5" 
                fill="none" 
                viewBox="0 0 24 24" 
                stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>

            <span>{{ session('error') }}</span>
        </div>

        <script>
            setTimeout(() => {
                const alert = document.getElementById('error-alert');

                if (alert) {
                    alert.classList.add('opacity-0', 'translate-y-2');
                    setTimeout(() => alert.remove(), 300);
                }
            }, 3000);
        </script>
    @endif
    @if(session('success'))
        <div 
            id="success-alert"
            class="fixed bottom-5 right-5 z-50 flex items-center gap-3 bg-green-500 text-white px-5 py-3 rounded-xl shadow-lg transition-all duration-300"
        >
            <!-- Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" 
                class="h-5 w-5" 
                fill="none" 
                viewBox="0 0 24 24" 
                stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round" 
                    stroke-linejoin="round" 
                    d="M5 13l4 4L19 7" />
            </svg>

            <span>{{ session('success') }}</span>
        </div>

        <script>
            setTimeout(() => {
                const alert = document.getElementById('success-alert');

                if (alert) {
                    alert.classList.add('opacity-0', 'translate-y-2');

                    setTimeout(() => {
                        alert.remove();
                    }, 300);
                }
            }, 3000);
        </script>
    @endif


    <h1 class="text-2xl font-bold mb-4">Item Categories Management</h1>

    {{-- input form toggle open and close --}}
    
    <!-- Toggle Form Card -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm mb-6 overflow-hidden">
        
        <!-- Header - Click to Toggle -->
        <button onclick="toggleForm()" type="button" class="w-full px-5 py-4 flex items-center justify-between bg-gray-50 hover:bg-gray-100 transition-colors cursor-pointer">
            <div class="flex items-center gap-3">
                <h2 class="text-lg font-medium text-gray-800">Add New Item Category</h2>
            </div>
            <svg id="toggle-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <!-- Form Content (Hidden by default) -->
        <div id="form-content" class="hidden px-5 pb-5 border-t border-gray-200">
            <form action="{{ route('item-categories.store') }}" method="POST" class="space-y-4 mt-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    
                    <!-- Item Category Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Item Category Name</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" 
                                    class="h-4 w-4 text-gray-400" 
                                    fill="none" 
                                    viewBox="0 0 24 24" 
                                    stroke="currentColor" 
                                    stroke-width="2">
                                    <path stroke-linecap="round" 
                                        stroke-linejoin="round" 
                                        d="M20 7L12 3 4 7m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <input type="text" name="name" id="name" required 
                                class="pl-10 block w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-colors"
                                placeholder="Enter item category name">
                        </div>
                    </div>

                    <!-- Kode Item Category -->
                    <div>
                        <label for="kd_category" class="block text-sm font-medium text-gray-700 mb-1">Kode Item Category</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                </svg>
                            </div>
                            <input type="text" name="kd_category" id="kd_category" required 
                                class="pl-10 block w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-colors"
                                placeholder="e.g. LB">
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end pt-2">
                    <button type="submit" class="flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors shadow-md hover:shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Item Category
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
        
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NO</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Item Category</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($itemCategories as $itemCategory)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $itemCategory->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $itemCategory->kd_category }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                            <!-- Action buttons (Edit/Delete) can go here -->
                            <button 
                            onclick="openEditModal({{ $itemCategory->id }}, '{{ $itemCategory->name }}', '{{ $itemCategory->kd_category }}')"
                            class="text-indigo-600 hover:text-indigo-900">
                            Edit
                        </button>
                        <form action="{{ route('item-categories.destroy', $itemCategory->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 ml-2" onclick="return confirm('Are you sure you want to delete this item category?')">
                                Delete
                            </button>
                        </form>
                    </td>                        
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- modal--}}
    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6 relative">
            
            <!-- Close Button -->
            <button onclick="closeEditModal()" 
                class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
                ✕
            </button>

            <h2 class="text-xl font-semibold mb-4">Edit Item Category</h2>

            <form id="editForm" method="POST">
                @csrf
                @method('PUT')

                <!-- Item Category Name -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Item Category Name
                    </label>
                    <input type="text" 
                        name="name" 
                        id="edit_name"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                        required>
                </div>

                <!-- Kode Item Category -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Kode Item Category
                    </label>
                    <input type="text" 
                        name="kd_category" 
                        id="edit_kd_category"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                        required>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end gap-2">
                    <button type="button"
                        onclick="closeEditModal()"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                        Cancel
                    </button>

                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>


</div>

<script>
    // Initialize Lucide icons
    lucide.createIcons();

    function toggleForm() {
        const formContent = document.getElementById('form-content');
        const toggleIcon = document.getElementById('toggle-icon');
        
        if (formContent.classList.contains('hidden')) {
            formContent.classList.remove('hidden');
            toggleIcon.classList.add('rotate-180');
        } else {
            formContent.classList.add('hidden');
            toggleIcon.classList.remove('rotate-180');
        }
    }

    // Open Edit Modal
    function openEditModal(id, name, kd_category) {
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_kd_category').value = kd_category;

        // Set form action dynamically
        document.getElementById('editForm').action = `/item-categories/${id}`;

        // Show modal
        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('editModal').classList.add('flex');
    }

    // Close Edit Modal
    function closeEditModal() {
        document.getElementById('editModal').classList.remove('flex');
        document.getElementById('editModal').classList.add('hidden');
    }
</script>
@endsection