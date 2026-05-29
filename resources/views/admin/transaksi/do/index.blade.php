@extends('template')

@section('title', 'Delivery Order')

@section('content')

<div class="container mx-auto p-4">

    <h1 class="text-2xl font-bold mb-6">
        Delivery Order
    </h1>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm mb-6 overflow-hidden">

        <button onclick="toggleForms()" type="button" class="w-full px-5 py-4 flex items-center justify-between bg-gray-50 hover:bg-gray-100 transition-colors cursor-pointer">
            <div class="flex items-center gap-3">
                <h2 class="text-lg font-medium text-gray-800">Add New Delivery Order</h2>
            </div>
            <svg id="toggle-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <div id="form-content" class="hidden px-5 pb-5 border-t border-gray-200">
            <form action="{{ route('delivery-orders.store') }}" method="POST">
    
                @csrf
    
                <!-- Header -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    
                    <!-- SO -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Sales Order
                        </label>
    
                        <select
                            name="sales_order_id"
                            id="sales_order_id"
                            class="w-full px-4 py-2.5 border rounded-lg bg-gray-50"
                            required>
    
                            <option value="">
                                -- Select SO --
                            </option>
    
                            @foreach($salesOrders as $so)
    
                                <option
                                    value="{{ $so->id }}"
                                    data-so='@json($so)'
                                >
                                    {{ $so->nomor_so }}
                                </option>
    
                            @endforeach
    
                        </select>
                    </div>
    
                    <!-- Customer -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Customer
                        </label>
    
                        <input
                            type="text"
                            id="customer_name"
                            readonly
                            class="w-full px-4 py-2.5 bg-gray-100 border rounded-lg">
                    </div>
    
                    <!-- Nomor PO -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nomor PO
                        </label>
    
                        <input
                            type="text"
                            id="nomor_po"
                            readonly
                            class="w-full px-4 py-2.5 bg-gray-100 border rounded-lg">
                    </div>
    
                </div>
    
                <!-- Items -->
                <div class="mb-6">
    
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Item SO
                    </label>
    
                    <div class="overflow-x-auto">
    
                        <table class="w-full border border-gray-200 rounded-lg">
    
                            <thead class="bg-gray-100">
    
                                <tr>
    
                                    <th class="px-4 py-2 text-left">
                                        Item
                                    </th>
    
                                    <th class="px-4 py-2 text-left">
                                        Kode
                                    </th>
    
                                    <th class="px-4 py-2 text-left">
                                        Satuan
                                    </th>
    
                                    <th class="px-4 py-2 text-right">
                                        Qty SO
                                    </th>
    
                                    <th class="px-4 py-2 text-right">
                                        Qty Kirim
                                    </th>
    
                                </tr>
    
                            </thead>
    
                            <tbody id="items_table">
    
                                <tr>
    
                                    <td colspan="5" class="text-center py-4 text-gray-500">
                                        Pilih Sales Order dulu
                                    </td>
    
                                </tr>
    
                            </tbody>
    
                        </table>
    
                    </div>
    
                </div>
    
    
                <!-- Detail Item -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <input type="hidden" name="customer_id" id="input_customer_id">
    
                    <!-- Kode Item -->
                    <div>
    
                        <input
                            type="hidden"
                            id="kd_item"
                            readonly
                            class="w-full px-4 py-2.5 bg-gray-100 border rounded-lg">
                    </div>
    
                    <!-- Satuan -->
                    <div>
    
                        <input
                            type="hidden"
                            id="satuan"
                            readonly
                            class="w-full px-4 py-2.5 bg-gray-100 border rounded-lg">
                    </div>
    
                    <!-- Qty SO -->
                    <div>
    
                        <input
                            type="hidden"
                            id="qty_so"
                            readonly
                            class="w-full px-4 py-2.5 bg-gray-100 border rounded-lg">
                    </div>
    
                </div>
    
                <!-- Catatan -->
                <div class="mb-6">
    
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Catatan
                    </label>
    
                    <textarea
                        name="catatan"
                        rows="3"
                        class="w-full px-4 py-2.5 border rounded-lg"></textarea>
    
                </div>
    
                <!-- Submit -->
                <div class="flex justify-end">
    
                    <button
                        type="submit"
                        class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
    
                        Save Delivery Order
    
                    </button>
    
                </div>
    
            </form>
        </div>


    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadwo-sm p-5">
        <table class="min-w-full text-sm text-left">

            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-3">No DO</th>
                    <th class="px-4 py-3">Sales Order</th>
                    <th class="px-4 py-3">Customer</th>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3 text-right">Total Item</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($deliveryOrders as $do)

                    <tr class="border-t hover:bg-gray-50">

                        <td class="px-4 py-3 font-medium">
                            {{ $do->nomor_do }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $do->sales_order->nomor_so ?? '-' }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $do->customer->nama_customer ?? '-' }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $do->created_at->format('d-m-Y') }}
                        </td>

                        <td class="px-4 py-3 text-right">
                            {{ $do->details->count() }}
                        </td>

                        <td class="px-4 py-3 text-center space-x-2">

                             <a
                                href="{{ route('invoice.generate', $do->id) }}"
                                class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                                Generate Invoice
                            </a>

                            <a
                                href="{{ route('delivery-orders.print', $do->id) }}"
                                target="_self"
                                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                                Print DO
                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="text-center py-6 text-gray-500">
                            Tidak ada data Delivery Order
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>
    </div>

</div>

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

    document.getElementById('sales_order_id')
    .addEventListener('change', function () {

        let selected =
            this.options[this.selectedIndex];

        if (!selected.value) return;

        let so =
            JSON.parse(selected.dataset.so);

        // customer
        document.getElementById('customer_name').value =
            so.customer.nama_customer;

        // nomor po
        document.getElementById('nomor_po').value =
            so.nomor_po ?? '';

        // // hidden
        // document.getElementById('input_sales_order_id').value =
        //     so.id;

        document.getElementById('input_customer_id').value =
            so.customer.id;

        // table
        let table =
            document.getElementById('items_table');

        table.innerHTML = '';

        so.details.forEach((detail, index) => {

            let sisaQty =
                detail.qty - detail.qty_delivered;

            table.innerHTML += `
                <tr class="border-t">

                    <td class="px-4 py-2">
                        ${detail.item.deskripsi}
                    </td>

                    <td class="px-4 py-2">
                        ${detail.item.kd_item}
                    </td>

                    <td class="px-4 py-2">
                        ${detail.item.satuan}
                    </td>

                    <td class="px-4 py-2 text-right">
                        ${detail.qty}
                    </td>

                    <td class="px-4 py-2">

                        <input
                            type="hidden"
                            name="details[${index}][sales_order_detail_id]"
                            value="${detail.id}">

                        <input
                            type="hidden"
                            name="details[${index}][item_id]"
                            value="${detail.item.id}">

                        <input
                            type="number"
                            step="0.01"
                            min="0"
                            max="${sisaQty}"
                            name="details[${index}][qty]"
                            class="w-full px-3 py-2 border rounded-lg">

                    </td>

                </tr>
            `;
        });

    });

</script>

@endsection
