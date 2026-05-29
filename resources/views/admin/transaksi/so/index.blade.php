
@extends('template')
@section('title', 'Sales Order')
@section('content')

<div class="container mx-auto p-4">

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

    <h1 class="text-2xl font-bold mb-4">
        Sales Order
    </h1>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm mb-6 overflow-hidden">

         <button onclick="toggleForms()" type="button" class="w-full px-5 py-4 flex items-center justify-between bg-gray-50 hover:bg-gray-100 transition-colors cursor-pointer">
            <div class="flex items-center gap-3">
                <h2 class="text-lg font-medium text-gray-800">Add New Sales Order</h2>
            </div>
            <svg id="toggle-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <div id="form-content" class="hidden px-5 pb-5 border-t border-gray-200">
            <form action="{{ route('sales-orders.store') }}" method="POST">
    
                @csrf
    
                <!-- Header SO -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    
                    <!-- Customer -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Customer
                        </label>
    
                        <select
                            name="customer_id"
                            id="customer_id"
                            required
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg">
    
                            <option value="">-- Select Customer --</option>
    
                            @foreach($customers as $customer)
                                <option
                                    value="{{ $customer->id }}"
                                    data-sales="{{ $customer->sales->name }}"
                                    data-area="{{ $customer->area->name }}"
                                    data-sales-id="{{ $customer->sales->id }}"
                                >
                                    {{ $customer->nama_customer }}
                                </option>
                            @endforeach
    
                        </select>
                    </div>
    
                    <!-- Sales -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Sales
                        </label>
    
                        <input
                            type="text"
                            id="sales_name"
                            readonly
                            class="w-full px-4 py-2.5 bg-gray-100 border border-gray-300 rounded-lg">
                        
                        <input type="hidden" name="sales_id" id="sales_id">
                    </div>
    
                    <!-- Area -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Area
                        </label>
    
                        <input
                            type="text"
                            id="area_name"
                            readonly
                            class="w-full px-4 py-2.5 bg-gray-100 border border-gray-300 rounded-lg">
                    </div>
    
                    <!-- Nomor PO -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nomor PO
                        </label>
    
                        <input
                            type="text"
                            name="nomor_po"
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg">
                    </div>
    
                    <!-- Tanggal SO -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Tanggal SO
                        </label>
    
                        <input
                            type="date"
                            name="tanggal_so"
                            value="{{ date('Y-m-d') }}"
                            required
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg">
                    </div>
    
                    <!-- Delivery Request -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Delivery Request
                        </label>
    
                        <input
                            type="date"
                            name="delivery_request"
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg">
                    </div>
    
                </div>
    
                <!-- Item Table -->
                <div class="overflow-x-auto">
    
                    <table class="min-w-full divide-y divide-gray-200">
    
                        <thead class="bg-gray-50">
    
                            <tr>
    
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Item
                                </th>
    
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Qty
                                </th>
    
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Harga
                                </th>
    
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Subtotal
                                </th>
    
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Action
                                </th>
    
                            </tr>
    
                        </thead>
    
                        <tbody id="item-table">
    
                            <tr>
    
                                <!-- Item -->
                                <td class="p-2">
    
                                    <select
                                        name="items[0][item_id]"
                                        class="item-select w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg"
                                        required>
    
                                        <option value="">-- Select Item --</option>
    
                                        @foreach($items as $item)
    
                                            <option
                                                value="{{ $item->id }}"
                                                data-harga="{{ $item->harga }}">
                                                
                                                {{ $item->deskripsi }}
    
                                            </option>
    
                                        @endforeach
    
                                    </select>
    
                                </td>
    
                                <!-- Qty -->
                                <td class="p-2">
    
                                    <input
                                        type="number"
                                        name="items[0][qty]"
                                        class="qty w-full px-3 py-2 border rounded-lg"
                                        value="1"
                                        min="1"
                                        required>
    
                                </td>
    
                                <!-- Harga -->
                                <td class="p-2">
    
                                    <input
                                        type="number"
                                        name="items[0][harga]"
                                        class="harga w-full px-3 py-2 border rounded-lg"
                                        required>
    
                                </td>
    
                                <!-- Subtotal -->
                                <td class="p-2">
    
                                    <input
                                        type="text"
                                        class="subtotal w-full px-3 py-2 bg-gray-100 border rounded-lg"
                                        readonly>
    
                                </td>
    
                                <!-- Action -->
                                <td class="p-2">
    
                                    <button
                                        type="button"
                                        onclick="removeRow(this)"
                                        class="px-3 py-2 bg-red-500 text-white rounded-lg">
    
                                        Delete
    
                                    </button>
    
                                </td>
    
                            </tr>
    
                        </tbody>
    
                    </table>
    
                </div>
    
                <!-- Add Item -->
                <div class="mt-4">
    
                    <button
                        type="button"
                        onclick="addRow()"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg">
    
                        + Add Item
    
                    </button>
    
                </div>
    
                <!-- Grand Total -->
                <div class="mt-6 flex justify-end">
    
                    <div class="w-full md:w-1/3">
    
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Grand Total
                        </label>
    
                        <input
                            type="text"
                            id="grand_total"
                            readonly
                            class="w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg text-xl font-bold">
    
                    </div>
    
                </div>
    
                <!-- Submit -->
                <div class="mt-6 flex justify-end">
    
                    <button
                        type="submit"
                        class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700">
    
                        Save Sales Order
    
                    </button>
    
                </div>
    
            </form>
        </div>

        
    </div>
    <div class="bg-white rounded-xl border border-gray-200 shadwo-sm p-5">
        <table class="min-w-full divide-y divide-gray-200">

            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase"></th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No SO</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sales</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ppn</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total After Ppn</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Grand Total</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($salesOrders as $so)
                    <tr>
                        <td class="px-4 py-4">
                            <button
                                onclick="toggleDetail({{ $so->id }})"
                                class="w-7 h-7 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-sm">
                                
                                <span id="icon-{{ $so->id }}">+</span>
                            </button>
                        </td>
                        <td class="px-4 py-3 font-medium">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 font-medium">{{ $so->nomor_so }}</td>
                        <td class="px-4 py-3">{{ $so->tanggal_so }}</td>
                        <td class="px-4 py-3">{{ $so->customer->nama_customer ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $so->sales->name ?? '-' }}</td>
                        <td class="px-4 py-3">
                            Rp {{ number_format($so->total_dpp, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3">
                            Rp {{ number_format($so->ppn_total, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3">
                            Rp {{ number_format($so->grand_total, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs rounded bg-gray-100">
                                {{ $so->status }}
                            </span>
                        </td>

                        <td class="px-4 py-3">
                            <button
                                type="button"
                                onclick="toggleDetail({{ $so->id }})"
                                class="text-indigo-600 hover:underline">
                                Detail
                            </button>
                        </td>
                    </tr>

                    {{-- DETAIL --}}
                    <tr id="detail-{{ $so->id }}" class="hidden bg-gray-50">
                        <td colspan="7" class="px-4 py-4">

                            <div class="text-sm font-semibold mb-2">
                                Detail Item
                            </div>

                            <table class="w-full text-sm border">

                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="p-2 text-left">Item</th>
                                        <th class="p-2 text-left">Qty</th>
                                        <th class="p-2 text-left">Harga</th>
                                        <th class="p-2 text-left">Subtotal</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($so->details as $detail)
                                        <tr class="border-t">
                                            <td class="p-2">
                                                {{ $detail->item->deskripsi ?? '-' }}
                                            </td>
                                            <td class="p-2">{{ $detail->qty }}</td>
                                            <td class="p-2">
                                                Rp {{ number_format($detail->harga, 0, ',', '.') }}
                                            </td>
                                            <td class="p-2">
                                                Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>

                        </td>
                    </tr>

                @endforeach

            </tbody>

        </table>
    </div>


</div>

<script>

    // Customer change
    document.getElementById('customer_id').addEventListener('change', function () {

        let selected = this.options[this.selectedIndex];

        document.getElementById('sales_name').value =
            selected.dataset.sales || '';

        document.getElementById('area_name').value =
            selected.dataset.area || '';

        document.getElementById('sales_id').value =
            selected.dataset.salesId || '';

    });

    // Auto harga
    document.addEventListener('change', function (e) {

        if (e.target.classList.contains('item-select')) {

            let row = e.target.closest('tr');

            let harga =
                e.target.options[e.target.selectedIndex]
                .dataset.harga;

            row.querySelector('.harga').value = harga;

            calculateRow(row);
        }

    });

    // Qty & harga calculate
    document.addEventListener('input', function (e) {

        if (
            e.target.classList.contains('qty') ||
            e.target.classList.contains('harga')
        ) {

            let row = e.target.closest('tr');

            calculateRow(row);
        }

    });

    function calculateRow(row) {

        let qty =
            parseFloat(row.querySelector('.qty').value) || 0;

        let harga =
            parseFloat(row.querySelector('.harga').value) || 0;

        let subtotal = qty * harga;

        row.querySelector('.subtotal').value =
            subtotal.toLocaleString();

        calculateGrandTotal();
    }

    function calculateGrandTotal() {

        let total = 0;

        document.querySelectorAll('.subtotal').forEach(el => {

            total += parseFloat(
                el.value.replace(/,/g, '')
            ) || 0;

        });

        document.getElementById('grand_total').value =
            total.toLocaleString();
    }

    let rowIndex = 1;

    function addRow() {

        let table =
            document.getElementById('item-table');

        let firstRow =
            table.querySelector('tr');

        let newRow =
            firstRow.cloneNode(true);

        // reset values
        newRow.querySelectorAll('input').forEach(input => {

            input.value = '';

        });

        newRow.querySelector('.qty').value = 1;

        // rename input
        newRow.querySelectorAll('select, input').forEach(el => {

            if (el.name) {

                el.name =
                    el.name.replace(/\d+/, rowIndex);

            }

        });

        table.appendChild(newRow);

        rowIndex++;
    }

    function removeRow(button) {

        let rows =
            document.querySelectorAll('#item-table tr');

        if (rows.length > 1) {

            button.closest('tr').remove();

            calculateGrandTotal();
        }
    }

</script>

<script>
    function toggleForms() {
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
