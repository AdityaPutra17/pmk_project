@extends('template')
@section('title', 'Customer Management')
@section('content')
<div class="container mx-auto px-3 sm:px-4 py-4 overflow-x-hidden">
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


    <h1 class="text-2xl font-bold mb-4">Customer Management</h1>

    {{-- input form toggle open and close --}}
    
    <!-- Toggle Form Card -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm mb-6 overflow-hidden">

        <!-- Header - Click to Toggle -->
        <button onclick="toggleForm()" type="button"
            class="w-full px-5 py-4 flex items-center justify-between bg-gray-50 hover:bg-gray-100 transition-colors cursor-pointer">
            
            <div class="flex items-center gap-3">
                <h2 class="text-lg font-medium text-gray-800">Add New Customer</h2>
            </div>

            <svg id="toggle-icon" xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 text-gray-400 transition-transform duration-200"
                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <!-- Form Content -->
        <div id="form-content" class="hidden px-5 pb-5 border-t border-gray-200">

            <form action="{{ route('customers.store') }}" method="POST" class="space-y-4 mt-4">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <!-- Nama Customer -->
                    <div>
                        <label for="nama_customer" class="block text-sm font-medium text-gray-700 mb-1">
                            Customer Name
                        </label>

                        <input type="text"
                            name="nama_customer"
                            id="nama_customer"
                            value="{{ old('nama_customer') }}"
                            required
                            class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="Enter customer name">

                        @error('nama_customer')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Alamat -->
                    <div class="md:col-span-2">
                        <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">
                            Address
                        </label>

                        <textarea
                            name="alamat"
                            id="alamat"
                            rows="3"
                            required
                            class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="Enter address">{{ old('alamat') }}</textarea>

                        @error('alamat')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- NPWP -->
                    <div>
                        <label for="npwp" class="block text-sm font-medium text-gray-700 mb-1">
                            NPWP
                        </label>

                        <input type="text"
                            name="npwp"
                            id="npwp"
                            value="{{ old('npwp') }}"
                            required
                            class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="Enter NPWP">

                        @error('npwp')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- No Telepon -->
                    <div>
                        <label for="no_telp" class="block text-sm font-medium text-gray-700 mb-1">
                            Phone Number
                        </label>

                        <input type="text"
                            name="no_telp"
                            id="no_telp"
                            value="{{ old('no_telp') }}"
                            required
                            class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="08xxxxxxxxxx">

                        @error('no_telp')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sales -->
                   <select name="sales_id"
                        id="sales_id"
                        required
                        onchange="setArea()"
                        class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg">

                        <option value="">-- Select Sales --</option>

                        @foreach($sales as $item)
                            <option 
                                value="{{ $item->id }}"
                                data-area="{{ $item->area->name }}"
                                data-area-id="{{ $item->area_id }}"
                                {{ old('sales_id') == $item->id ? 'selected' : '' }}>
                                
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Area -->
                    <input type="text"
                        name="area_name"
                        id="area_name"
                        required
                        class="block w-full px-4 py-2.5 bg-gray-100 border border-gray-300 rounded-lg" readonly>
                    </input>

                    <input type="hidden" name="area_id" id="area_id">

                </div>

                <!-- Submit -->
                <div class="flex justify-end pt-2">
                    <button type="submit"
                        class="flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors shadow-md hover:shadow-lg">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>

                        Add Customer
                    </button>
                </div>
            </form>
        </div>
    </div>
        
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 overflow-x-auto">

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 w-10"></th>

                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        NO
                    </th>

                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        Customer
                    </th>

                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase hidden md:table-cell">
                        Kode
                    </th>

                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase hidden lg:table-cell">
                        Sales
                    </th>

                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        Actions
                    </th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">

                @foreach($customers as $customer)

                <!-- MAIN ROW -->
                <tr>
                    <!-- TOGGLE BUTTON -->
                    <td class="px-4 py-4">
                        <button
                            onclick="toggleDetail({{ $customer->id }})"
                            class="w-7 h-7 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-sm">
                            
                            <span id="icon-{{ $customer->id }}">+</span>
                        </button>
                    </td>

                    <!-- NOMOR -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $loop->iteration }}
                    </td>

                    <!-- CUSTOMER -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $customer->nama_customer }}
                    </td>

                    <!-- KODE -->
                    <td class="px-6 py-4 whitespace-nowrap hidden md:table-cell">
                        {{ $customer->kd_customer }}
                    </td>

                    <!-- SALES -->
                    <td class="px-6 py-4 whitespace-nowrap hidden lg:table-cell">
                        {{ $customer->sales->name ?? 'N/A' }}
                    </td>

                    <!-- ACTION -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <button
                            type="button"
                            class="text-indigo-600 hover:text-indigo-900">
                            Edit
                        </button>

                        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 ml-2" onclick="return confirm('Are you sure you want to delete this customer?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>

                <!-- DETAIL ROW -->
                <tr id="detail-{{ $customer->id }}" class="hidden bg-gray-50">
                    <td colspan="6" class="px-6 py-4">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">

                            <div>
                                <span class="font-semibold">NPWP:</span>
                                {{ $customer->npwp }}
                            </div>

                            <div>
                                <span class="font-semibold">No Telepon:</span>
                                {{ $customer->no_telp }}
                            </div>

                            <div>
                                <span class="font-semibold">Sales:</span>
                                {{ $customer->sales->name ?? 'N/A' }}
                            </div>

                            <div>
                                <span class="font-semibold">Area:</span>
                                {{ $customer->area->name ?? 'N/A' }}
                            </div>

                            <div class="md:col-span-2">
                                <span class="font-semibold">Alamat:</span>
                                {{ $customer->alamat }}
                            </div>

                        </div>

                    </td>
                </tr>

                @endforeach

            </tbody>
        </table>
    </div>

    {{-- modal--}}
    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 overflow-y-auto p-4">

        <div class="bg-white rounded-xl shadow-lg w-full max-w-3xl p-6 relative">

            <!-- Close Button -->
            <button onclick="closeEditModal()"
                class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
                ✕
            </button>

            <h2 class="text-xl font-semibold mb-6">Edit Customer</h2>

            <form id="editForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <!-- Nama Customer -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Customer Name
                        </label>

                        <input type="text"
                            name="nama_customer"
                            id="edit_nama_customer"
                            required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    </div>

                    <!-- Kode Customer -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Customer Code
                        </label>

                        <input type="text"
                            name="kd_customer"
                            id="edit_kd_customer"
                            required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" readonly>
                    </div>

                    <!-- Alamat -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Address
                        </label>

                        <textarea
                            name="alamat"
                            id="edit_alamat"
                            rows="3"
                            required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"></textarea>
                    </div>

                    <!-- NPWP -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            NPWP
                        </label>

                        <input type="text"
                            name="npwp"
                            id="edit_npwp"
                            required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    </div>

                    <!-- No Telepon -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Phone Number
                        </label>

                        <input type="text"
                            name="no_telp"
                            id="edit_no_telp"
                            required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    </div>

                    <!-- Sales -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Sales
                        </label>

                        <select
                            name="sales_id"
                            id="edit_sales_id"
                            onchange="setEditArea()"
                            required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">

                            <option value="">-- Select Sales --</option>

                            @foreach($sales as $item)
                                <option
                                    value="{{ $item->id }}"
                                    data-area="{{ $item->area->name }}"
                                    data-area-id="{{ $item->area_id }}">
                                    
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Area -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Area
                        </label>

                        <input type="text"
                            id="edit_area_name"
                            readonly
                            class="w-full px-4 py-2.5 bg-gray-100 border border-gray-300 rounded-lg">

                        <input type="hidden"
                            name="area_id"
                            id="edit_area_id">
                    </div>

                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end gap-2 pt-4">

                    <button type="button"
                        onclick="closeEditModal()"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                        Cancel
                    </button>

                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                        Update Customer
                    </button>

                </div>
            </form>
        </div>
    </div>


</div>

{{-- auto set area by sales --}}
<script>
    function setArea() {
        const salesSelect = document.getElementById('sales_id');

        const selectedOption =
            salesSelect.options[salesSelect.selectedIndex];

        const areaName =
            selectedOption.getAttribute('data-area');

        const areaId =
            selectedOption.getAttribute('data-area-id');

        // tampilkan nama area
        document.getElementById('area_name').value = areaName;

        // kirim area_id ke backend
        document.getElementById('area_id').value = areaId;
    }
</script>

{{-- // Toggle Form and Modal Scripts --}}

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
   function openEditModal(button) {

        document.getElementById('edit_nama_customer').value =
            button.dataset.nama;

        document.getElementById('edit_kd_customer').value =
            button.dataset.kd;

        document.getElementById('edit_alamat').value =
            button.dataset.alamat;

        document.getElementById('edit_npwp').value =
            button.dataset.npwp;

        document.getElementById('edit_no_telp').value =
            button.dataset.telp;

        document.getElementById('edit_sales_id').value =
            button.dataset.sales;

        document.getElementById('edit_area_name').value =
            button.dataset.areaName;

        document.getElementById('edit_area_id').value =
            button.dataset.area;

        document.getElementById('editForm').action =
            `/customers/${button.dataset.id}`;

        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('editModal').classList.add('flex');
    }

    function setEditArea() {

        const salesSelect =
            document.getElementById('edit_sales_id');

        const selectedOption =
            salesSelect.options[salesSelect.selectedIndex];

        const areaName =
            selectedOption.getAttribute('data-area');

        const areaId =
            selectedOption.getAttribute('data-area-id');

        document.getElementById('edit_area_name').value = areaName;
        document.getElementById('edit_area_id').value = areaId;
    }

    // Close Edit Modal
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