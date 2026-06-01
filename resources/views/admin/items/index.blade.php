@extends('template')
@section('title', 'Item Management')
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

    
    <h1 class="text-2xl font-bold mb-4">Item Management</h1>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm mb-6 overflow-hidden">
        
        <!-- Header - Click to Toggle -->
        <button onclick="toggleForm()" type="button" class="w-full px-5 py-4 flex items-center justify-between bg-gray-50 hover:bg-gray-100 transition-colors cursor-pointer">
            <div class="flex items-center gap-3">
                <h2 class="text-lg font-medium text-gray-800">Add New Item</h2>
            </div>
            <svg id="toggle-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <!-- Form Content (Hidden by default) -->
        <div id="form-content" class="hidden px-5 pb-5 border-t border-gray-200">
            <form action="{{ route('items.store') }}" method="POST" class="space-y-4 mt-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <!-- Category -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Category
                        </label>

                        <select
                            name="category_id"
                            required
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">

                            <option value="">-- Select Category --</option>

                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }} ({{ $category->kd_category }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Harga -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Harga
                        </label>

                        <input type="number"
                            name="harga"
                            step="0.01"
                            required
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                            placeholder="Enter harga">
                    </div>

                    <!-- Satuan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Satuan
                        </label>

                        {{-- <input type="text"
                            name="satuan"
                            required
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                            placeholder="e.g pcs, box, kg"> --}}
                        <select name="satuan" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            <option value="pcs">pcs</option>
                            <option value="box">box</option>
                            <option value="kg">kg</option>
                        </select>

                    </div>

                    <!-- Deskripsi -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Deskripsi
                        </label>

                        <textarea
                            name="deskripsi"
                            rows="4"
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                            placeholder="Enter item description"></textarea>
                    </div>

                </div>

                <!-- Submit Button -->
                <div class="flex justify-end pt-2">
                    <button type="submit" class="flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors shadow-md hover:shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Item
                    </button>
                </div>
            </form>
        </div>
    </div>


    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-3 w-10"></th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NO</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Item</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Category</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Category</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($items as $item)
                <tr>
                    <td class="px-4 py-4">
                        <button
                            onclick="toggleDetail({{ $item->id }})"
                            class="w-7 h-7 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-sm">
                            
                            <span id="icon-{{ $item->id }}">+</span>
                        </button>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->kd_item }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->category->kd_category }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->category->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <!-- Action buttons (Edit/Delete) can go here -->
                        <button 
                            onclick='openEditModal(
                                {{ $item->id }},
                                @json($item->kd_item),
                                @json($item->category_id),
                                @json($item->harga),
                                @json($item->satuan),
                                @json($item->deskripsi)
                            )'
                            class="text-indigo-600 hover:text-indigo-900">
                            Edit
                        </button>
                        <form action="{{ route('items.destroy', $item->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 ml-2" onclick="return confirm('Are you sure you want to delete this item?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                {{-- Detail Row (Hidden by default) --}}
                <tr id="detail-{{ $item->id }}" class="hidden bg-gray-50">
                    <td colspan="7" class="px-6 py-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <p><strong>Item Name:</strong> {{ $item->kd_item }}</p>
                            <p><strong>Kode Category:</strong> {{ $item->category->kd_category }}</p>
                            <p><strong>Nama Category:</strong> {{ $item->category->name }}</p>
                            <p><strong>Price:</strong> {{ $item->harga }}</p>
                            <p><strong>Description:</strong> {{ $item->deskripsi }}</p>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- modal--}}
    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-6 relative">

            <!-- Close Button -->
            <button 
                onclick="closeEditModal()"
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                ✕
            </button>

            <h2 class="text-xl font-bold text-gray-800 mb-6">
                Edit Item
            </h2>

            <form id="editForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Kode Item -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Kode Item
                    </label>

                    <input type="text"
                        name="kd_item"
                        id="edit_kd_item"
                        readonly
                        class="w-full px-4 py-2.5 bg-gray-100 border border-gray-300 rounded-lg text-gray-500 cursor-not-allowed">
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Category
                    </label>

                    <select
                        name="category_id"
                        id="edit_category_id"
                        required
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">

                        <option value="">-- Select Category --</option>

                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->name }} ({{ $category->kd_category }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Harga -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Harga
                    </label>

                    <input type="number"
                        name="harga"
                        id="edit_harga"
                        step="0.01"
                        required
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>

                <!-- Satuan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Satuan
                    </label>

                    <input type="text"
                        name="satuan"
                        id="edit_satuan"
                        required
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Deskripsi
                    </label>

                    <textarea
                        name="deskripsi"
                        id="edit_deskripsi"
                        rows="4"
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"></textarea>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end gap-2 pt-2">

                    <button
                        type="button"
                        onclick="closeEditModal()"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                        Cancel
                    </button>

                    <button
                        type="submit"
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
    function openEditModal(
        id,
        kd_item,
        category_id,
        harga,
        satuan,
        deskripsi
    ) {

        document.getElementById('edit_kd_item').value = kd_item;
        document.getElementById('edit_category_id').value = category_id;
        document.getElementById('edit_harga').value = harga;
        document.getElementById('edit_satuan').value = satuan;
        document.getElementById('edit_deskripsi').value = deskripsi;

        document.getElementById('editForm').action = `/items/${id}`;

        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('editModal').classList.add('flex');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.remove('flex');
        document.getElementById('editModal').classList.add('hidden');
    
    }
</script>

<script>
    function toggleDetail(id) {

        const detail =
            document.getElementById(`detail-${id}`);

        const icon =
            document.getElementById(`icon-${id}`);

        detail.classList.toggle('hidden');

        if (detail.classList.contains('hidden')) {
            icon.innerText = '+';
        } else {
            icon.innerText = '-';
        }
    }
</script>

@endsection