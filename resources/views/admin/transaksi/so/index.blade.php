@extends('template')

@section('title', 'Sales Order')

@section('content')

<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Success Alert -->
        @if(session('success'))
            <div id="success-alert" class="fixed bottom-5 right-5 z-50 flex items-center gap-3 bg-green-500 text-white px-5 py-3 rounded-xl shadow-lg transition-all duration-300 transform translate-y-0 opacity-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            <script>
                setTimeout(() => {
                    const alert = document.getElementById('success-alert');
                    if(alert) {
                        alert.classList.add('opacity-0', 'translate-y-2');
                        setTimeout(() => alert.remove(), 300);
                    }
                }, 3000);
            </script>
        @endif

        <!-- Page Header -->
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">
                    Sales Order
                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    Kelola pesanan penjualan dan detail item.
                </p>
            </div>
        </div>

        <!-- Form Section (Accordion) -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-8 transition-all duration-300">
            <button onclick="toggleForms()" type="button" class="w-full px-6 py-5 flex items-center justify-between bg-gradient-to-r from-white to-gray-50 hover:bg-gray-50 transition-all cursor-pointer group">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-indigo-100 rounded-lg text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <div class="text-left">
                        <h2 class="text-lg font-bold text-gray-800">Buat Sales Order Baru</h2>
                        <p class="text-xs text-gray-500 font-normal">Isi detail pesanan dan item barang</p>
                    </div>
                </div>
                <svg id="toggle-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 transform transition-transform duration-300 group-hover:text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div id="form-content" class="hidden border-t border-gray-100 bg-gray-50/30">
                <form action="{{ route('sales-orders.store') }}" method="POST" class="p-6 space-y-6">
                    @csrf

                    <!-- Header Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        
                        <!-- Customer -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                Customer <span class="text-red-500">*</span>
                            </label>
                            <select name="customer_id" id="customer_id" required class="block w-full rounded-lg border-gray-300 pl-4 pr-10 py-3 bg-white focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm shadow-sm border transition-colors">
                                <option value="">-- Pilih Customer --</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" data-sales="{{ $customer->sales->name ?? '-' }}" data-area="{{ $customer->area->name ?? '-' }}" data-sales-id="{{ $customer->sales->id ?? '' }}">
                                        {{ $customer->nama_customer }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sales (Auto Fill) -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                Sales
                            </label>
                            <input type="text" id="sales_name" readonly placeholder="Pilih customer" class="block w-full rounded-lg border-gray-200 bg-gray-100 text-gray-600 sm:text-sm border py-3 px-4 cursor-not-allowed">
                            <input type="hidden" name="sales_id" id="sales_id">
                        </div>

                        <!-- Area (Auto Fill) -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                Area
                            </label>
                            <input type="text" id="area_name" readonly placeholder="Pilih customer" class="block w-full rounded-lg border-gray-200 bg-gray-100 text-gray-600 sm:text-sm border py-3 px-4 cursor-not-allowed">
                        </div>

                        <!-- Nomor PO -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                Nomor PO
                            </label>
                            <input type="text" name="nomor_po" placeholder="Contoh: PO/2024/001" class="block w-full rounded-lg border-gray-300 pl-4 py-3 bg-white focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm shadow-sm border">
                        </div>

                        <!-- Tanggal SO -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                Tanggal SO <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggal_so" value="{{ date('Y-m-d') }}" required class="block w-full rounded-lg border-gray-300 pl-4 py-3 bg-white focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm shadow-sm border">
                        </div>

                        <!-- Delivery Request -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                Delivery Request
                            </label>
                            <input type="date" name="delivery_request" class="block w-full rounded-lg border-gray-300 pl-4 py-3 bg-white focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm shadow-sm border">
                        </div>

                        <!-- Jenis Pajak -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                Jenis Pajak <span class="text-red-500">*</span>
                            </label>
                            <select name="jenis_pajak" required class="block w-full rounded-lg border-gray-300 pl-4 pr-10 py-3 bg-white focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm shadow-sm border">
                                <option value="ppn">PPN 11%</option>
                                <option value="non_ppn">Non PPN</option>
                            </select>
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <label class="block text-sm font-bold text-gray-800">
                                Detail Item
                            </label>
                            <button type="button" onclick="addRow()" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                                Tambah Item
                            </button>
                        </div>

                        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-sm">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/5">Item</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/6">Qty</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/6">Harga</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/6">Subtotal</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-10">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="item-table" class="bg-white divide-y divide-gray-200">
                                    <tr class="hover:bg-gray-50 transition-colors group">
                                        <td class="p-3">
                                            <select name="items[0][item_id]" class="item-select block w-full rounded-lg border-gray-300 py-2 px-3 bg-white focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border" required>
                                                <option value="">-- Pilih Item --</option>
                                                @foreach($items as $item)
                                                    <option value="{{ $item->id }}" data-harga="{{ $item->harga }}">
                                                        {{ $item->deskripsi }} ({{ $item->kd_item }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="p-3">
                                            <input type="number" name="items[0][qty]" class="qty block w-full rounded-lg border-gray-300 py-2 px-3 bg-white focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border" value="1" min="1" required>
                                        </td>
                                        <td class="p-3">
                                            <input type="number" name="items[0][harga]" class="harga block w-full rounded-lg border-gray-300 py-2 px-3 bg-white focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border" required>
                                        </td>
                                        <td class="p-3">
                                            <input type="text" class="subtotal block w-full rounded-lg bg-gray-100 border-gray-200 py-2 px-3 sm:text-sm border text-gray-600 cursor-not-allowed" readonly>
                                        </td>
                                        <td class="p-3 text-center">
                                            <button type="button" onclick="removeRow(this)" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors opacity-0 group-hover:opacity-100" title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Summary -->
                    <div class="flex justify-end">
                        <div class="w-full md:w-1/3 bg-gray-50 rounded-xl p-4 border border-gray-200 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-600">Subtotal</span>
                                <span class="text-base font-semibold text-gray-800" id="subtotal_summary">Rp 0</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-600">PPN</span>
                                <span class="text-base font-semibold text-gray-800" id="ppn_summary">Rp 0</span>
                            </div>
                            <div class="flex items-center justify-between border-t border-gray-200 pt-2 mt-2">
                                <span class="text-sm font-medium text-gray-600">Grand Total</span>
                                <span class="text-2xl font-bold text-indigo-600" id="grand_total">Rp 0</span>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end pt-4 border-t border-gray-100 gap-3">
                        <button type="button" onclick="toggleForms()" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg shadow-sm text-sm font-medium bg-white hover:bg-gray-50 focus:outline-none transition-colors">
                            Cancel
                        </button>
                        <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all transform active:scale-95">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Sales Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Search Section -->
        <div class="mb-8 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <form method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all"
                        placeholder="Cari berdasarkan nomor SO atau nama customer...">
                </div>
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-all">
                    Cari
                </button>
                @if($search)
                    <a href="{{ route('sales-orders.index') }}" class="px-6 py-2.5 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium rounded-lg transition-all">
                        Reset
                    </a>
                @endif
            </form>
        </div>
        <!-- Data Table Section -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="text-lg font-bold text-gray-800">Riwayat Sales Order</h3>
                <span class="text-xs font-medium text-gray-500 bg-white px-3 py-1 rounded-full border">
                    {{ $salesOrders->count() }} Records
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-500 font-medium border-b border-gray-100">
                        <tr>
                            <th class="px-4 py-4 font-semibold w-10"></th>
                            <th class="px-4 py-4 font-semibold">No SO</th>
                            <th class="px-4 py-4 font-semibold">Tanggal</th>
                            <th class="px-4 py-4 font-semibold">Customer</th>
                            <th class="px-4 py-4 font-semibold">Sales</th>
                            <th class="px-4 py-4 font-semibold text-right">Total</th>
                            <th class="px-4 py-4 font-semibold text-center">Status</th>
                            <th class="px-4 py-4 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse($salesOrders as $so)
                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="px-4 py-4">
                                    <button onclick="toggleDetail({{ $so->id }})" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-indigo-100 hover:text-indigo-600 flex items-center justify-center text-sm font-medium transition-colors">
                                        <span id="icon-{{ $so->id }}" class="transition-transform">+</span>
                                    </button>
                                </td>
                                <td class="px-4 py-4 font-medium text-indigo-600">
                                    {{ $so->nomor_so }}
                                </td>
                                <td class="px-4 py-4 text-gray-600">
                                    {{ \Carbon\Carbon::parse($so->tanggal_so)->format('d-m-Y') }}
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs">
                                            {{ substr($so->customer->nama_customer ?? 'C', 0, 1) }}
                                        </div>
                                        <span class="text-gray-700 font-medium">
                                            {{ $so->customer->nama_customer ?? '-' }}
                                        </span>
                                    </div>
                                </td>
                                                                <td class="px-4 py-4 text-gray-600">
                                    {{ $so->sales->name ?? '-' }}
                                </td>
                                <td class="px-4 py-4 text-right">
                                    <span class="text-gray-900 font-semibold">
                                        Rp {{ number_format($so->grand_total, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    @if($so->status == 'approved')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Approved
                                        </span>
                                    @elseif($so->status == 'pending')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ $so->status }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <div class="inline-flex items-center gap-1">
                                        <form action="{{ route('sales-orders.destroy', $so->id) }}" method="POST" onsubmit="return confirm('Hapus Sales Order ini? DATA TERKAIT PRIHAL SO SEPERTI DO JUGA AKAN IKUT TERHAPUS')" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <!-- Detail Row (Expandable) -->
                            <tr id="detail-{{ $so->id }}" class="hidden bg-gray-50">
                                <td colspan="8" class="px-4 py-4">
                                    <div class="bg-white rounded-xl border border-gray-200 p-4">
                                        <div class="flex items-center justify-between mb-4">
                                            <h4 class="text-sm font-bold text-gray-800">Detail Item SO</h4>
                                            <span class="text-xs text-gray-500">{{ $so->details->count() }} item</span>
                                        </div>
                                        <div class="overflow-x-auto">
                                            <table class="w-full text-sm">
                                                <thead class="bg-gray-100">
                                                    <tr>
                                                        <th class="p-3 text-left font-medium text-gray-600">Item</th>
                                                        <th class="p-3 text-right font-medium text-gray-600">Qty</th>
                                                        <th class="p-3 text-right font-medium text-gray-600">Harga</th>
                                                        <th class="p-3 text-right font-medium text-gray-600">Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-100">
                                                    @foreach($so->details as $detail)
                                                        <tr>
                                                            <td class="p-3">
                                                                <div class="font-medium text-gray-800">{{ $detail->item->deskripsi ?? '-' }}</div>
                                                                <div class="text-xs text-gray-500">{{ $detail->item->kd_item ?? '-' }}</div>
                                                            </td>
                                                            <td class="p-3 text-right">{{ $detail->qty }}</td>
                                                            <td class="p-3 text-right">Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                                                            <td class="p-3 text-right font-medium">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot class="bg-gray-50">
                                                    <tr>
                                                        <td colspan="3" class="p-3 text-right font-medium text-gray-600">Subtotal</td>
                                                        <td class="p-3 text-right font-medium">Rp {{ number_format($so->total_dpp, 0, ',', '.') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="p-3 text-right font-medium text-gray-600">PPN 11%</td>
                                                        <td class="p-3 text-right font-medium">Rp {{ number_format($so->ppn_total, 0, ',', '.') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="p-3 text-right font-bold text-gray-800">Grand Total</td>
                                                        <td class="p-3 text-right font-bold text-indigo-600">Rp {{ number_format($so->grand_total, 0, ',', '.') }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="text-lg font-medium text-gray-600">Belum ada Sales Order</p>
                                        <p class="text-sm text-gray-500 mt-1">Silakan buat pesanan baru untuk memulai.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex justify-between items-center">
                <div class="text-sm text-gray-600">
                    Menampilkan <span class="font-medium">{{ $salesOrders->firstItem() ?? 0 }}</span> hingga <span class="font-medium">{{ $salesOrders->lastItem() ?? 0 }}</span> dari <span class="font-medium">{{ $salesOrders->total() }}</span> data
                </div>
                <div>
                    {{ $salesOrders->links() }}
                </div>
            </div>
        </div>

    </div>
</div>

<!-- JavaScript Logic -->
<script>
    // Toggle Form
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

    // Toggle Detail
    function toggleDetail(id) {
        const detail = document.getElementById(`detail-${id}`);
        const icon = document.getElementById(`icon-${id}`);

        detail.classList.toggle('hidden');

        if (detail.classList.contains('hidden')) {
            icon.innerText = '+';
        } else {
            icon.innerText = '-';
        }
    }

    // Customer Change
    document.getElementById('customer_id').addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];

        document.getElementById('sales_name').value = selected.dataset.sales || '';
        document.getElementById('area_name').value = selected.dataset.area || '';
        document.getElementById('sales_id').value = selected.dataset.salesId || '';
    });

    // Auto Fill Harga & Calculate
    document.addEventListener('change', function (e) {
        if (e.target.classList.contains('item-select')) {
            const row = e.target.closest('tr');
            const harga = e.target.options[e.target.selectedIndex].dataset.harga;
            row.querySelector('.harga').value = harga || 0;
            calculateRow(row);
        }
    });

    // Qty & Harga Calculate
    document.addEventListener('input', function (e) {
        if (e.target.classList.contains('qty') || e.target.classList.contains('harga')) {
            const row = e.target.closest('tr');
            calculateRow(row);
        }
    });

    document.querySelector('select[name="jenis_pajak"]').addEventListener('change', function () {
        calculateGrandTotal();
    });

    // Calculate Row
    function calculateRow(row) {
        const qty = parseFloat(row.querySelector('.qty').value) || 0;
        const harga = parseFloat(row.querySelector('.harga').value) || 0;
        const subtotal = qty * harga;
        row.querySelector('.subtotal').value = subtotal.toLocaleString('id-ID');
        calculateGrandTotal();
    }

    function calculateGrandTotal() {
        let total = 0;

        document.querySelectorAll('.subtotal').forEach(el => {
            const value = el.value.replace(/\./g, '');
            total += parseFloat(value) || 0;
        });

        const jenisPajak = document.querySelector('select[name="jenis_pajak"]').value;
        const ppn = jenisPajak === 'ppn' ? total * 0.11 : 0;
        const grandTotal = total + ppn;

        document.getElementById('subtotal_summary').innerText = 'Rp ' + total.toLocaleString('id-ID');
        document.getElementById('ppn_summary').innerText = 'Rp ' + ppn.toLocaleString('id-ID');
        document.getElementById('grand_total').innerText = 'Rp ' + grandTotal.toLocaleString('id-ID');
    }

    // Add Row
    let rowIndex = 1;
    function addRow() {
        const table = document.getElementById('item-table');
        const firstRow = table.querySelector('tr');
        const newRow = firstRow.cloneNode(true);

        // Reset values
        newRow.querySelectorAll('input').forEach(input => input.value = '');
        newRow.querySelector('.qty').value = 1;

        // Rename inputs
        newRow.querySelectorAll('select, input').forEach(el => {
            if (el.name) {
                el.name = el.name.replace(/\d+/, rowIndex);
            }
        });

        table.appendChild(newRow);
        rowIndex++;
    }

    // Remove Row
    function removeRow(button) {
        const rows = document.querySelectorAll('#item-table tr');
        if (rows.length > 1) {
            button.closest('tr').remove();
            calculateGrandTotal();
        }
    }
</script>

<style>
    .rotate-180 {
        transform: rotate(180deg);
    }
</style>

@endsection