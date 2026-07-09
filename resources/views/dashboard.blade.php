@extends('template')

@section('title', 'Dashboard')

@section('content')

{{-- WRAPPER UTAMA --}}
<div class="bg-slate-50 min-h-screen p-4 md:p-6 lg:p-8 font-sans text-slate-800">

    {{-- HEADER SECTION --}}
    <div class="mb-8">
        
        {{-- <p class="text-slate-500 mt-1 text-sm font-medium">
            Welcome {{ Auth::user()->name }}...!
        </p> --}}
        <h1 class="text-3xl font-bold text-slate-900 tracking-tight">
            Dashboard
        </h1>
        <p class="text-slate-500 mt-1 text-sm font-medium">
            Monitoring Sales Order, Delivery Order, Invoice dan Customer
        </p>
    </div>

    {{-- KPI ROW 1 (Main Metrics) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">

        {{-- SALES ORDER --}}
        <a href="{{ route('sales-orders.index') }}" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 relative overflow-hidden group hover:shadow-md hover:-translate-y-1 transition-all duration-300">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-100 rounded-full opacity-20 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-center mb-1">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Sales Order</span>
                    <div class="p-2 rounded-lg bg-blue-50 text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                    </div>
                </div>
                <h2 class="text-xl font-bold text-slate-800">{{ $totalSO }}</h2>
                <p class="text-xs text-slate-400 mt-1 font-medium">Active orders</p>
                <h2 class="text-xl font-bold text-emerald-600 truncate">Rp {{ number_format($totalSalesOrder,0,',','.') }}</h2>
            </div>
        </a>

        {{-- CUSTOMER --}}
        <a href="{{ route('customers.index') }}" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 relative overflow-hidden group hover:shadow-md hover:-translate-y-1 transition-all duration-300">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-indigo-100 rounded-full opacity-20 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-center mb-3">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Customer</span>
                    <div class="p-2 rounded-lg bg-indigo-50 text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    </div>
                </div>
                <h2 class="text-xl font-bold text-slate-800">{{ $totalCustomer }}</h2>
                <p class="text-xs text-slate-400 mt-1 font-medium">Registered</p>
            </div>
        </a>

        {{-- PENDING DELIVERY --}}
        <a href="{{ route('delivery-orders.index') }}" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 relative overflow-hidden group hover:shadow-md hover:-translate-y-1 transition-all duration-300">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-orange-100 rounded-full opacity-20 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-center mb-3">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pending Delivery</span>
                    <div class="p-2 rounded-lg bg-orange-50 text-orange-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                    </div>
                </div>
                <h2 class="text-xl font-bold text-orange-600">{{ $pendingDelivery }}</h2>
                <p class="text-xs text-orange-500 mt-1 font-medium">Needs attention</p>
            </div>
        </a>

        
        {{-- TOTAL PIUTANG --}}
        <a href="{{ route('invoice.index') }}" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 relative overflow-hidden hover:shadow-md hover:-translate-y-1 transition-all duration-300">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Invoice Belum Lunas</span>
            <div class="flex items-center mb-2">
                <h2 class="text-xl font-bold text-red-600 mx-2">{{ $invoiceBelumLunas }}</h2> 
                <span class="text-xs bg-red-100 text-red-600 px-2 py-0.5 rounded-full font-bold">Overdue</span>
            </div>

            <div class="flex justify-between items-center mb-2">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Piutang</span>
            </div>
            <h2 class="text-xl font-bold text-orange-600">Rp {{ number_format($totalPiutang,0,',','.') }}</h2>
            <div class="w-full bg-slate-100 h-1.5 rounded-full mt-3 overflow-hidden">
                <div class="bg-orange-500 h-1.5 rounded-full" style="width: {{ $piutangProgress }}%"></div>
            </div>
        </a>

    </div>

    {{-- KPI ROW 2 (Secondary Metrics) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">

        {{-- DELIVERY ORDER --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 relative overflow-hidden">
            <div class="flex justify-between items-center mb-2">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Delivery Order</span>
            </div>
            <h2 class="text-xl font-bold text-slate-700">{{ $totalDO }}</h2>
            <div class="w-full bg-slate-100 h-1.5 rounded-full mt-3 overflow-hidden">
                <div class="bg-slate-600 h-1.5 rounded-full" style="width: {{ $deliveryProgress }}%"></div>
            </div>
        </div>

        {{-- INVOICE --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 relative overflow-hidden">
            <div class="flex justify-between items-center mb-2">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Invoice</span>
            </div>
            <h2 class="text-xl font-bold text-slate-700">{{ $totalInvoice }}</h2>
            <div class="w-full bg-slate-100 h-1.5 rounded-full mt-3 overflow-hidden">
                <div class="bg-indigo-600 h-1.5 rounded-full" style="width: {{ $invoiceProgress }}%"></div>
            </div>
        </div>

        

    </div>

    {{-- CHART & RECENT SO SECTION --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        {{-- GRAFIK --}}
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-slate-800 text-lg">Sales Order Trend</h3>
                <select class="bg-slate-50 border border-slate-200 text-xs rounded-lg px-3 py-1 outline-none focus:border-indigo-500">
                    <option>Bulanan</option>
                    <option>Mingguan</option>
                </select>
            </div>
            <div style="height: 320px;" class="w-full">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        {{-- RECENT SALES ORDER --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h3 class="font-bold text-slate-800 text-lg mb-6">Recent Sales Order</h3>
            <div class="space-y-4">
                @forelse($recentSO as $so)
                <div class="group flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100 cursor-pointer">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-sm font-bold">
                            {{ substr($so->customer->nama_customer, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-semibold text-sm text-slate-800 group-hover:text-indigo-600 transition-colors">{{ $so->nomor_so }}</p>
                            <p class="text-xs text-slate-500">{{ $so->customer->nama_customer }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-slate-700">Rp {{ number_format($so->grand_total,0,',','.') }}</p>
                        <p class="text-[10px] text-slate-400">{{ \Carbon\Carbon::parse($so->created_at)->format('d M') }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-10 text-slate-400">
                    <p>Tidak ada data terbaru</p>
                </div>
                @endforelse
            </div>
            <a href="{{ route('sales-orders.index') }}" class="w-full mt-4 py-2 text-sm text-slate-500 hover:text-indigo-600 font-medium transition-colors">Lihat Semua &rarr;</a>
        </div>

    </div>

    {{-- TOP CUSTOMER & TOP PRODUCT --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

        {{-- TOP CUSTOMER --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100">
                <h3 class="font-bold text-slate-800 text-lg">Top Customer</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-3 font-bold">#</th>
                            <th class="px-6 py-3 font-bold">Customer</th>
                            <th class="px-6 py-3 font-bold text-right">Total Sales</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($topCustomers as $index => $customer)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-400">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 font-medium text-slate-800">{{ $customer->nama_customer }}</td>
                            <td class="px-6 py-4 text-right font-bold text-emerald-600">Rp {{ number_format($customer->total,0,',','.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-slate-400">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- TOP PRODUK --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100">
                <h3 class="font-bold text-slate-800 text-lg">Top Produk Terjual</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-3 font-bold">#</th>
                            <th class="px-6 py-3 font-bold">Produk</th>
                            <th class="px-6 py-3 font-bold text-right">Total Qty</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($topProducts as $index => $product)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-400">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 font-medium text-slate-800">{{ $product->deskripsi }}</td>
                            <td class="px-6 py-4 text-right font-bold text-blue-600">{{ $product->total_qty }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-slate-400">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- FOOTER DASHBOARD --}}
    <div class="text-center text-xs text-slate-400 mt-10 pb-6">
        <p>&copy; {{ date('Y') }} Sistem Anda. All rights reserved.</p>
    </div>

</div>

{{-- SCRIPT LIBRARIES --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{{-- CHART CONFIGURATION --}}
<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    
    // Gradient Setup
    let gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(99, 102, 241, 0.5)'); // Indigo
    gradient.addColorStop(1, 'rgba(99, 102, 241, 0.0)');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Sales Order',
                data: @json($chartData),
                backgroundColor: gradient,
                borderColor: '#4F46E5',
                borderWidth: 1,
                borderRadius: 6,
                borderSkipped: false,
                barThickness: 20,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#1E293B',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    padding: 10,
                    cornerRadius: 8,
                    displayColors: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#F1F5F9',
                        borderDash: [5, 5]
                    },
                    ticks: {
                        color: '#94A3B8',
                        font: {
                            size: 11
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#94A3B8',
                        font: {
                            size: 11
                        }
                    }
                }
            }
        }
    });

    lucide.createIcons();
</script>

@endsection 