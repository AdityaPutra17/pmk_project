@extends('template')

@section('title', 'Delivery Order')

@section('content')

<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">
                    Delivery Order
                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    Kelola pengiriman barang berdasarkan Sales Order.
                </p>
            </div>
        </div>

        <!-- Form Section (Accordion Style) -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-8 transition-all duration-300">
            <button onclick="toggleForms()" type="button" class="w-full px-6 py-5 flex items-center justify-between bg-gradient-to-r from-white to-gray-50 hover:bg-gray-50 transition-all cursor-pointer group">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-indigo-100 rounded-lg text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="text-left">
                        <h2 class="text-lg font-bold text-gray-800">Input Delivery Order Baru</h2>
                        <p class="text-xs text-gray-500 font-normal">Isi detail pengiriman dan qty barang</p>
                    </div>
                </div>
                <svg id="toggle-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 transform transition-transform duration-300 group-hover:text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div id="form-content" class="hidden border-t border-gray-100 bg-gray-50/30">
                <form action="{{ route('delivery-orders.store') }}" method="POST" class="p-6">
                    @csrf

                    <!-- Header Fields: SO, Customer, PO -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        
                        <!-- SO Selection -->
                        <div class="relative">
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                Sales Order <span class="text-red-500">*</span>
                            </label>
                            <div class="relative mt-1 rounded-md shadow-sm">
                                <select
                                    name="sales_order_id"
                                    id="sales_order_id"
                                    class="block w-full rounded-lg border-gray-300 pl-4 pr-10 py-3 bg-white focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm shadow-sm border transition-colors"
                                    required>
                                    <option value="">-- Pilih Nomor SO --</option>
                                    @foreach($salesOrders as $so)
                                        <option value="{{ $so->id }}" data-so='@json($so)'>
                                            {{ $so->nomor_so }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Name (ReadOnly) -->
                        <div class="relative">
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                Customer
                            </label>
                            <div class="flex items-center mt-1">
                                <input
                                    type="text"
                                    id="customer_name"
                                    readonly
                                    placeholder="Pilih SO terlebih dahulu"
                                    class="block w-full rounded-lg border-gray-200 bg-gray-100 text-gray-600 sm:text-sm border py-3 px-4 cursor-not-allowed">
                            </div>
                            <input type="hidden" name="customer_id" id="input_customer_id">
                        </div>

                        <!-- Nomor PO (ReadOnly) -->
                        <div class="relative">
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                Nomor PO Customer
                            </label>
                            <div class="flex items-center mt-1">
                                <input
                                    type="text"
                                    id="nomor_po"
                                    readonly
                                    class="block w-full rounded-lg border-gray-200 bg-gray-100 text-gray-600 sm:text-sm border py-3 px-4 cursor-not-allowed">
                            </div>
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-4">
                            <label class="block text-sm font-bold text-gray-800">
                                Detail Item SO
                            </label>
                            <span class="text-xs text-indigo-600 bg-indigo-50 px-2 py-1 rounded-full font-medium">
                                Qty Sisa = (Qty SO - Qty Kirim)
                            </span>
                        </div>
                        
                        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-sm">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/4">Item Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Satuan</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Max Qty</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/3">Qty Kirim</th>
                                    </tr>
                                </thead>
                                <tbody id="items_table" class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-400 italic">
                                            Silakan pilih Sales Order untuk melihat detail item.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Catatan -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Catatan / Instruksi Pengiriman
                        </label>
                        <textarea
                            name="catatan"
                            rows="3"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-3"
                            placeholder="Contoh: Di-terima di pos keamanan utama, hubungi packaging officer..."></textarea>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end pt-4 border-t border-gray-100 gap-3">
                        <button
                            type="button"
                            onclick="toggleForms()"
                            class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg shadow-sm text-sm font-medium bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                            Cancel
                        </button>
                        <button
                            type="submit"
                            class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform active:scale-95">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Delivery Order
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Data Table Section (List DO) -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="text-lg font-bold text-gray-800">Riwayat Delivery Order</h3>
                <span class="text-xs font-medium text-gray-500 bg-white px-3 py-1 rounded-full border">
                    Total: {{ $deliveryOrders->count() }} Records
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-500 font-medium border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 font-semibold">No DO</th>
                            <th class="px-6 py-4 font-semibold">Sales Order</th>
                            <th class="px-6 py-4 font-semibold">Customer</th>
                            <th class="px-6 py-4 font-semibold">Tanggal</th>
                            <th class="px-6 py-4 font-semibold text-right">Total Item</th>
                            <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse($deliveryOrders as $do)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-medium text-indigo-600">
                                    {{ $do->nomor_do }}
                                </td>
                                <td class="px-6 py-4 text-gray-700">
                                    {{ $do->sales_order->nomor_so ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    {{ $do->customer->nama_customer ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-gray-500">
                                    {{ \Carbon\Carbon::parse($do->created_at)->format('d-m-Y') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ $do->details->count() }} Item
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('delivery-orders.print', $do->id) }}" target="_blank" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none transition-colors" >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                        </svg>
                                        Print DO
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                        <p class="text-base font-medium">Tidak ada data Delivery Order</p>
                                        <p class="text-sm">Silakan buat DO baru untuk memulai.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- JavaScript Logic -->
<script>

function toggleForms() {
    const formContent = document.getElementById('form-content');
    const toggleIcon = document.getElementById('toggle-icon');

    formContent.classList.toggle('hidden');
    toggleIcon.classList.toggle('rotate-180');
}

document.getElementById('sales_order_id').addEventListener('change', function () {

    const selected = this.options[this.selectedIndex];

    if (!selected.value) {
        document.getElementById('customer_name').value = '';
        document.getElementById('nomor_po').value = '';
        document.getElementById('input_customer_id').value = '';

        document.getElementById('items_table').innerHTML = `
            <tr>
                <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-400 italic">
                    Silakan pilih Sales Order untuk melihat detail item.
                </td>
            </tr>
        `;
        return;
    }

    const so = JSON.parse(selected.dataset.so);

    document.getElementById('customer_name').value =
        so.customer?.nama_customer || '';

    document.getElementById('nomor_po').value =
        so.nomor_po || '';

    document.getElementById('input_customer_id').value =
        so.customer?.id || '';

    const tableBody =
        document.getElementById('items_table');

    tableBody.innerHTML = '';

    if (so.details && so.details.length > 0) {

        so.details.forEach((detail, index) => {

            let qtyDelivered =
                detail.qty_delivered || 0;

            let maxQty =
                detail.qty - qtyDelivered;

            let isDisabled =
                maxQty <= 0;

            let statusLabel =
                isDisabled
                    ? '<span class="text-xs text-red-500 font-medium">(Terpenuhi)</span>'
                    : '';

            tableBody.innerHTML += `
                <tr class="hover:bg-gray-50 transition-colors">

                    <td class="px-6 py-4 text-gray-900 font-medium">
                        ${detail.item?.deskripsi ?? '-'}
                    </td>

                    <td class="px-6 py-4 text-gray-500 font-mono text-xs">
                        ${detail.item?.kd_item ?? '-'}
                    </td>

                    <td class="px-6 py-4 text-gray-500">
                        ${detail.item?.satuan ?? '-'}
                    </td>

                    <td class="px-6 py-4 text-right text-gray-700 font-semibold">
                        ${maxQty} ${statusLabel}
                    </td>

                    <td class="px-6 py-4">

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
                            max="${maxQty}"
                            name="details[${index}][qty]"
                            ${isDisabled ? 'disabled' : ''}
                            class="w-full px-3 py-2 border rounded-lg">
                    </td>

                </tr>
            `;
        });

    } else {

        tableBody.innerHTML = `
            <tr>
                <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-400 italic">
                    Detail Item tidak ditemukan.
                </td>
            </tr>
        `;
    }

});

</script>

    <!-- Styling tambahan untuk rotated icon -->
    <style>
        .rotate-180 {
            transform: rotate(180deg);
        }
    </style>

@endsection