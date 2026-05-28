@extends('template')
@section('title', 'Sales Management')
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

    
    <h1 class="text-2xl font-bold mb-4">Sales Management</h1>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm mb-6 overflow-hidden">
        
        <!-- Header - Click to Toggle -->
        <button onclick="toggleForm()" type="button" class="w-full px-5 py-4 flex items-center justify-between bg-gray-50 hover:bg-gray-100 transition-colors cursor-pointer">
            <div class="flex items-center gap-3">
                <h2 class="text-lg font-medium text-gray-800">Add New Sales</h2>
            </div>
            <svg id="toggle-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <!-- Form Content (Hidden by default) -->
        <div id="form-content" class="hidden px-5 pb-5 border-t border-gray-200">
            <form action="{{ route('sales.store') }}" method="POST" class="space-y-4 mt-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <!-- Sales Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                            Sales Name
                        </label>

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
                                        d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>

                            <input type="text" 
                                name="name" 
                                id="name" 
                                required
                                class="pl-10 block w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                placeholder="Enter sales name">
                        </div>
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                            Phone Number
                        </label>

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
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.129a11.042 11.042 0 005.516 5.516l1.129-2.257a1 1 0 011.21-.502l4.493 1.498A1 1 0 0121 15.72V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>

                            <input type="text" 
                                name="phone" 
                                id="phone" 
                                required
                                class="pl-10 block w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                placeholder="e.g. 08123456789">
                        </div>
                    </div>

                    <!-- Dropdown Area -->
                    <div>
                        <label for="area_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Area
                        </label>

                        <select 
                            name="area_id" 
                            id="area_id"
                            required
                            class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            
                            <option value="">-- Select Area --</option>

                            @foreach($areas as $area)
                                <option value="{{ $area->id }}">
                                    {{ $area->name }} ({{ $area->kd_area }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <!-- Submit Button -->
                <div class="flex justify-end pt-2">
                    <button type="submit" class="flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors shadow-md hover:shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Sales
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Sales</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Area</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($sales as $s)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $s->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $s->kd_sales }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $s->area->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $s->phone }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <!-- Action buttons (Edit/Delete) can go here -->
                        <button 
                            onclick='openEditModal(
                                {{ $s->id }},
                                @json($s->name),
                                @json($s->kd_sales),
                                @json($s->phone),
                                {{ $s->area_id }}
                            )'
                            class="text-indigo-600 hover:text-indigo-900">
                            Edit
                        </button>
                        <form action="{{ route('sales.destroy', $s->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 ml-2" onclick="return confirm('Are you sure you want to delete this area?')">
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

        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-6 relative">

            <!-- Close Button -->
            <button 
                onclick="closeEditModal()"
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                ✕
            </button>

            <h2 class="text-xl font-bold text-gray-800 mb-6">
                Edit Sales
            </h2>

            <form id="editForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Sales Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Sales Name
                    </label>

                    <input type="text"
                        name="name"
                        id="edit_name"
                        required
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>

                <!-- Kode Sales -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Kode Sales
                    </label>

                    <input type="text"
                        name="kd_sales"
                        id="edit_kd_sales"
                        readonly
                        class="w-full px-4 py-2.5 bg-gray-100 border border-gray-300 rounded-lg text-gray-500 cursor-not-allowed">
                </div>

                <!-- Phone -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Phone Number
                    </label>

                    <input type="text"
                        name="phone"
                        id="edit_phone"
                        required
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>

                <!-- Area -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Area
                    </label>

                    <select
                        name="area_id"
                        id="edit_area_id"
                        required
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">

                        <option value="">-- Select Area --</option>

                        @foreach($areas as $area)
                            <option value="{{ $area->id }}">
                                {{ $area->name }} ({{ $area->kd_area }})
                            </option>
                        @endforeach
                    </select>
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
    function openEditModal(id, name, kd_sales, phone, area_id) {

        document.getElementById('edit_name').value = name;
        document.getElementById('edit_kd_sales').value = kd_sales;
        document.getElementById('edit_phone').value = phone;
        document.getElementById('edit_area_id').value = area_id;

        // route resource
        document.getElementById('editForm').action = `/sales/${id}`;

        // show modal
        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('editModal').classList.add('flex');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.remove('flex');
        document.getElementById('editModal').classList.add('hidden');
    
    }
</script>

@endsection