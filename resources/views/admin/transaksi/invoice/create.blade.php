@extends('template')

@section('title', 'Create Invoice')

@section('content')

<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">
                    Buat Invoice Baru
                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    Isi data invoice dan detail tagihan pelanggan.
                </p>
            </div>
            <a href="{{ route('invoice.index') }}" class="hidden sm:inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>

        <form method="POST" action="{{ route('invoice.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Left Column - Form Fields -->
                <div class="lg:col-span-12  space-y-6">
                    
                    <!-- Basic Info Card -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                            <h3 class="text-lg font-bold text-gray-800">Data Invoice</h3>
                        </div>
                        <div class="p-6 space-y-6">
                            
                            <!-- Tanggal & Jenis -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Tanggal Invoice <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="date"
                                        name="tanggal"
                                        value="{{ date('Y-m-d') }}"
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-3"
                                        required
                                    >
                                </div>
                            </div>

                            <!-- DO & Customer -->
                            {{-- <div class="grid grid-cols-2 sm:grid-cols-2 gap-6"> --}}
                                <div>
                                    <div class="flex items-center justify-between mb-4">
                                        <label class="block text-sm font-bold text-gray-800">
                                            Delivery Order
                                        </label>

                                        <button
                                            type="button"
                                            onclick="addDORow()"
                                            class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-indigo-700 bg-indigo-100 hover:bg-indigo-200">

                                            Tambah DO
                                        </button>
                                        
                                    </div>

                                    <div class="overflow-hidden rounded-xl border border-gray-200 shadow-sm">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="px-4 py-3 text-left">
                                                        Delivery Order
                                                    </th>
                                                    <th class="px-4 py-3 text-left">
                                                        Customer
                                                    </th>
                                                    <th class="px-4 py-3 text-center">
                                                        Aksi
                                                    </th>
                                                </tr>
                                            </thead>

                                            <tbody id="do-table">

                                                <tr class="do-row">

                                                    <td class="p-3">

                                                        <select
                                                            name="delivery_order_ids[]"
                                                            class="do-select w-full border rounded-lg p-2"
                                                            onchange="loadDO(this)"
                                                            required>

                                                            <option value="">
                                                                -- Pilih DO --
                                                            </option>

                                                            @foreach($deliveryOrders as $do)

                                                                <option
                                                                    value="{{ $do->id }}"
                                                                    data-do='@json($do)'>
                                                                    {{ $do->nomor_do }}
                                                                </option>

                                                            @endforeach
                                                            
                                                            <input
                                                                type="hidden"
                                                                name="customer_id"
                                                                id="customer_id">

                                                        </select>

                                                    </td>

                                                    <td class="p-3 customer-name">
                                                        -
                                                    </td>

                                                    <td class="p-3 text-center">

                                                        <button
                                                            type="button"
                                                            onclick="removeDORow(this)"
                                                            class="text-red-500">
                                                            Hapus
                                                        </button>

                                                    </td>

                                                </tr>

                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            {{-- </div> --}}

                        </div>
                    </div>

                    <!-- Items Table Card -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
                            <h3 class="text-lg font-bold text-gray-800">Detail Item</h3>
                            <span class="text-xs text-indigo-600 bg-indigo-50 px-2 py-1 rounded-full font-medium">
                                Otomatis dari DO
                            </span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm text-left">
                                <thead class="bg-gray-50 text-gray-500 font-medium border-b border-gray-100">
                                    <tr>

                                        <th class="px-6 py-3 font-semibold text-right">DO</th>
                                        <th class="px-6 py-3 font-semibold">Item</th>
                                        <th class="px-6 py-3 font-semibold text-right">Qty</th>
                                        <th class="px-6 py-3 font-semibold text-right">Harga</th>
                                        <th class="px-6 py-3 font-semibold text-right">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody id="invoice_items" class="divide-y divide-gray-100">
                                    <tr>
                                        <td colspan="4" class="px-6 py-10 text-center text-gray-400 italic">
                                            Silakan pilih Delivery Order untuk melihat detail item.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Catatan Card -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                            <h3 class="text-lg font-bold text-gray-800">Catatan</h3>
                        </div>
                        <div class="p-6">
                            <textarea
                                name="catatan"
                                rows="4"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-3"
                                placeholder="Tulis catatan atau instruksi khusus..."
                            ></textarea>
                        </div>
                        
                        <button
                            type="submit"
                            class="w-full inline-flex items-center justify-center px-6 py-4 border border-transparent text-base font-medium rounded-lg shadow-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:scale-[1.02] active:scale-[0.98]"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Invoice
                        </button>
                    </div>
                    


                </div>

                <!-- Right Column - Summary -->
                <div class="space-y-6 hidden">
                    
                    <!-- Payment Summary Card -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden sticky top-6">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-indigo-600 to-indigo-700">
                            <h3 class="text-lg font-bold text-white">Ringkasan Pembayaran</h3>
                        </div>
                        <div class="p-6 space-y-6">
                            
                            <!-- Nominal Bayar -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Nominal Pembayaran
                                </label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">Rp</span>
                                    </div>
                                    <input
                                        type="number"
                                        name="nominal_dp"
                                        id="nominal_dp"
                                        value="0"
                                        min="0"
                                        class="block w-full pl-12 pr-4 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-3"
                                    >
                                </div>
                            </div>

                            <hr class="border-gray-100">

                            <!-- Totals -->
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Subtotal (DPP)</span>
                                    <span class="text-sm font-medium text-gray-900" id="total_dpp_view">Rp 0</span>
                                    <input type="hidden" name="total_dpp" id="total_dpp">
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm text-gray-600">PPN 11%</span>
                                        <span class="text-xs text-gray-400">( Pajak )</span>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900" id="ppn_total_view">Rp 0</span>
                                    <input type="hidden" name="ppn_total" id="ppn_total">
                                </div>
                                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                    <span class="text-base font-bold text-gray-900">Grand Total</span>
                                    <span class="text-xl font-bold text-indigo-600" id="grand_total_view">Rp 0</span>
                                    <input type="hidden" name="grand_total" id="grand_total">
                                </div>
                                
                                <hr class="border-gray-100">
                                
                                <div class="flex items-center justify-between bg-yellow-50 p-4 rounded-lg border border-yellow-100">
                                    <div>
                                        <span class="block text-xs font-medium text-yellow-600 uppercase">Sisa Tagihan</span>
                                    </div>
                                    <span class="text-lg font-bold text-yellow-700" id="sisa_tagihan_view">Rp 0</span>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </form>

    </div>
</div>

<!-- JavaScript Logic -->
<script>
    let currentTotal = 0;
    let totalTerbayar = 0;

    const deliveryOrderSelect = document.getElementById('delivery_order');
    const nominalDpInput = document.getElementById('nominal_dp');

    if(deliveryOrderSelect) {
        deliveryOrderSelect.addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];

            if(!selected.dataset.do) {
                // Reset form
                document.getElementById('customer_name').value = '';
                document.getElementById('customer_id').value = '';
                document.getElementById('invoice_items').innerHTML = `
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-400 italic">
                            Silakan pilih Delivery Order untuk melihat detail item.
                        </td>
                    </tr>
                `;
                currentTotal = 0;
                totalTerbayar = 0;
                calculateTotal();
                return;
            }

            const data = JSON.parse(selected.dataset.do);
            
            // Calculate total terbayar dari invoice sebelumnya
            totalTerbayar = 0;
            if(data.invoices && data.invoices.length > 0) {
                data.invoices.forEach(inv => {
                    totalTerbayar += Number(inv.nominal_dp ?? 0);
                });
            }

            // Update customer info
            document.getElementById('customer_name').value = data.customer ? data.customer.nama_customer : '';
            document.getElementById('customer_id').value = data.customer ? data.customer.id : '';

            // Generate items table
            const tbody = document.getElementById('invoice_items');
            tbody.innerHTML = '';
            currentTotal = 0;

            if(data.details && data.details.length > 0) {
                data.details.forEach((item, index) => {
                    const harga = item.sales_order_detail.harga;
                    const subtotal = item.sales_order_detail.subtotal;
                    
                    currentTotal += Number(subtotal);

                    tbody.innerHTML += `
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">
                                    ${item.item ? item.item.deskripsi : '-'}
                                </div>
                                <div class="text-xs text-gray-500">
                                    ${item.item ? item.item.kd_item : ''}
                                </div>
                                <input type="hidden" name="items[${index}][do_detail_id]" value="${item.id}">
                                <input type="hidden" name="items[${index}][so_detail_id]" value="${item.sales_order_detail.id}">
                            </td>
                            <td class="px-6 py-4 text-right text-gray-900 font-medium">
                                ${item.qty}
                                <input type="hidden" name="items[${index}][qty]" value="${item.qty}">
                            </td>
                            <td class="px-6 py-4 text-right text-gray-600">
                                Rp ${Number(harga).toLocaleString('id-ID')}
                                <input type="hidden" name="items[${index}][harga]" value="${harga}">
                            </td>
                            <td class="px-6 py-4 text-right text-gray-900 font-semibold">
                                Rp ${Number(subtotal).toLocaleString('id-ID')}
                                <input type="hidden" name="items[${index}][subtotal]" value="${subtotal}">
                            </td>
                        </tr>
                    `;
                });
            } else {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-400 italic">
                            Detail Item tidak ditemukan.
                        </td>
                    </tr>
                `;
            }

            calculateTotal();
        });
    }

    if(nominalDpInput) {
        nominalDpInput.addEventListener('keyup', calculateTotal);
        nominalDpInput.addEventListener('change', calculateTotal);
    }

    function calculateTotal() {
        const dpp = currentTotal;
        const ppn = Math.ceil(dpp * 0.11);
        const grand = dpp + ppn;

        const pembayaranBaru = parseFloat(document.getElementById('nominal_dp').value) || 0;
        const sisaSetelahBayar = Math.max(0, grand - totalTerbayar - pembayaranBaru);

        // Update hidden inputs
        document.getElementById('total_dpp').value = dpp;
        document.getElementById('ppn_total').value = ppn;
        document.getElementById('grand_total').value = grand;

        // Update display
        document.getElementById('total_dpp_view').innerText = 'Rp ' + dpp.toLocaleString('id-ID');
        document.getElementById('ppn_total_view').innerText = 'Rp ' + ppn.toLocaleString('id-ID');
        document.getElementById('grand_total_view').innerText = 'Rp ' + grand.toLocaleString('id-ID');
        document.getElementById('sisa_tagihan_view').innerText = 'Rp ' + sisaSetelahBayar.toLocaleString('id-ID');
    }

</script>

<script>
    let rowIndex = 1;

function addDORow()
{
    let html = `
        <tr class="do-row">

            <td class="p-3">

                <select
                    name="delivery_order_ids[]"
                    class="do-select w-full border rounded-lg p-2"
                    onchange="loadDO(this)"
                    required>

                    <option value="">
                        -- Pilih DO --
                    </option>

                    @foreach($deliveryOrders as $do)

                        <option
                            value="{{ $do->id }}"
                            data-do='@json($do)'>
                            {{ $do->nomor_do }}
                        </option>

                    @endforeach

                </select>

            </td>

            <td class="p-3 customer-name">
                -
            </td>

            <td class="p-3 text-center">

                <button
                    type="button"
                    onclick="removeDORow(this)"
                    class="text-red-500">
                    Hapus
                </button>

            </td>

        </tr>
    `;

    document
        .getElementById('do-table')
        .insertAdjacentHTML(
            'beforeend',
            html
        );
}

function removeDORow(btn)
{
    btn.closest('tr').remove();

    rebuildItems();
}

function loadDO(select)
{
    let row =
        select.closest('tr');

    let option =
        select.options[
            select.selectedIndex
        ];

    if(!option.dataset.do)
    {
        row.querySelector(
            '.customer-name'
        ).innerHTML = '-';

        rebuildItems();

        return;
    }

    let data =
        JSON.parse(option.dataset.do);

    row.querySelector(
        '.customer-name'
    ).innerHTML =
        data.customer.nama_customer;

    document.getElementById(
        'customer_id'
    ).value =
        data.customer.id;

    rebuildItems();
}

function rebuildItems()
{
    let tbody =
        document.getElementById(
            'invoice_items'
        );

    tbody.innerHTML = '';

    let total = 0;
    let index = 0;

    document
    .querySelectorAll('.do-select')
    .forEach(select => {

        let option =
            select.options[
                select.selectedIndex
            ];

        if(!option.dataset.do)
        {
            return;
        }

        let data =
            JSON.parse(option.dataset.do);

        data.details.forEach(detail => {

            let harga =
                detail.sales_order_detail.harga;

            let subtotal =
                detail.qty * harga;

            total += subtotal;

            tbody.innerHTML += `
                <tr>

                    <td class="px-4 py-2">
                        ${data.nomor_do}
                    </td>

                    <td class="px-4 py-2">
                        ${detail.item.deskripsi}
                    </td>

                    <td class="px-4 py-2">
                        ${detail.qty}
                    </td>

                    <td class="px-4 py-2">
                        Rp ${Number(harga)
                            .toLocaleString('id-ID')}
                    </td>

                    <td class="px-4 py-2">
                        Rp ${Number(subtotal)
                            .toLocaleString('id-ID')}
                    </td>

                    <input
                        type="hidden"
                        name="items[${index}][do_detail_id]"
                        value="${detail.id}">

                    <input
                        type="hidden"
                        name="items[${index}][so_detail_id]"
                        value="${detail.sales_order_detail.id}">

                    <input
                        type="hidden"
                        name="items[${index}][qty]"
                        value="${detail.qty}">

                    <input
                        type="hidden"
                        name="items[${index}][harga]"
                        value="${harga}">

                    <input
                        type="hidden"
                        name="items[${index}][subtotal]"
                        value="${subtotal}">
                </tr>
            `;

            index++;
        });

    });

    currentTotal = total;
    calculateTotal();
}
</script>
@endsection