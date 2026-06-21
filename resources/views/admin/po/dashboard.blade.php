@extends('template')

@section('title', 'Dashboard Purchase Order')

@section('content')
<!-- Tambahkan Font Inter, FontAwesome, & Chart.js -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght=400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="min-h-screen bg-slate-50 p-6 md:p-8" style="font-family: 'Inter', sans-serif;">
    
    <!-- HEADER SECTION -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Purchase Order Dashboard</h2>
            <p class="text-sm text-slate-500 mt-1">Pantau, analisis, dan kelola aktivitas pengadaan barang Anda.</p>
        </div>
        <div>
            <button class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm px-4 py-2.5 rounded-xl shadow-sm transition-all duration-200 gap-2 group">
                <i class="fa-solid fa-plus text-xs transition-transform group-hover:rotate-90"></i>
                <span>Buat PO Baru</span>
            </button>
        </div>
    </div>

    <!-- STATS CARDS SECTION -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total PO Card -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow duration-200 flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block mb-1">Total Purchase Orders</span>
                <h3 class="text-3xl font-bold text-slate-800">{{ number_format($totalPo, 0, ',', '.') }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                <i class="fa-solid fa-file-invoice-dollar"></i>
            </div>
        </div>

        <!-- Total Value Card -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow duration-200 flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block mb-1">Total Value (Grand Total)</span>
                <h3 class="text-2xl font-bold text-slate-800">Rp {{ number_format($totalValue, 0, ',', '.') }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                <i class="fa-solid fa-wallet"></i>
            </div>
        </div>

        <!-- Status Breakdown Card -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow duration-200 flex flex-col justify-between">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block mb-3">PO By Status</span>
            <div class="space-y-2 max-h-24 overflow-y-auto pr-1">
                @forelse($byStatus as $status => $c)
                    <div class="flex items-center justify-between text-sm">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200">
                            {{ $status ?? 'Belum ditentukan' }}
                        </span>
                        <span class="font-semibold text-slate-700">{{ $c }} <span class="text-xs font-normal text-slate-400">PO</span></span>
                    </div>
                @empty
                    <div class="text-slate-400 text-xs py-2 text-center">Belum ada data status</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- DETAILS SECTION (LINE CHART & TABLE) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Monthly Line Chart -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm lg:col-span-5 flex flex-col justify-between">
            <div class="mb-4">
                <h4 class="text-lg font-bold text-slate-800">PO per Bulan</h4>
                <p class="text-xs text-slate-400">Tren aktivitas pembuatan PO 6 bulan terakhir</p>
            </div>
            
            <!-- Wrapper Canvas untuk grafik -->
            <div class="relative w-full h-64">
                <canvas id="poLineChart"></canvas>
            </div>
        </div>

        <!-- Recent Purchase Orders Table -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm lg:col-span-7 flex flex-col">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h4 class="text-lg font-bold text-slate-800">Recent Purchase Orders</h4>
                    <p class="text-xs text-slate-400">Daftar transaksi terbaru masuk sistem</p>
                </div>
                <a href="#" class="text-xs font-semibold text-blue-600 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors duration-150">
                    Lihat Semua
                </a>
            </div>

            <div class="overflow-x-auto -mx-6">
                <div class="inline-block min-w-full align-middle px-6">
                    <table class="min-w-full divide-y divide-slate-100">
                        <thead>
                            <tr>
                                <th scope="col" class="py-3 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider w-12">#</th>
                                <th scope="col" class="py-3 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">PO Number</th>
                                <th scope="col" class="py-3 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Supplier</th>
                                <th scope="col" class="py-3 text-right text-xs font-semibold text-slate-400 uppercase tracking-wider">Grand Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($recent as $po)
                                <tr class="hover:bg-slate-50/70 transition-colors duration-150">
                                    <td class="py-3.5 text-sm text-slate-400 font-medium">{{ $loop->iteration }}</td>
                                    <td class="py-3.5 text-sm">
                                        <a href="{{ route('po.show', $po->id) }}" class="inline-flex items-center font-semibold text-blue-600 hover:text-blue-700 transition-colors gap-1.5">
                                            <i class="fa-regular fa-file-lines text-slate-400 text-xs"></i>
                                            {{ $po->po_number }}
                                        </a>
                                    </td>
                                    <td class="py-3.5 text-sm text-slate-600 font-medium">
                                        {{ $po->supplier->name ?? '-' }}
                                    </td>
                                    <td class="py-3.5 text-sm text-right font-bold text-slate-800">
                                        Rp {{ number_format($po->grand_total, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-sm text-slate-400">
                                        <div class="flex flex-col items-center gap-2">
                                            <i class="fa-regular fa-folder-open text-2xl text-slate-300"></i>
                                            <span>Belum ada data transaksi masuk.</span>
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
</div>

<!-- SCRIPT INITIALIZATION CHART.JS -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Konversi data dari PHP/Blade ke format Array JavaScript
        const labels = {!! json_encode($months) !!};
        const dataCounts = {!! json_encode($counts) !!};

        const ctx = document.getElementById('poLineChart').getContext('2d');
        
        // Membuat gradien warna di bawah garis (efek glow/area modern)
        const gradient = ctx.createLinearGradient(0, 0, 0, 200);
        gradient.addColorStop(0, 'rgba(59, 130, 246, 0.4)'); // Biru pudar atas
        gradient.addColorStop(1, 'rgba(59, 130, 246, 0.0)'); // Transparan bawah

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah PO',
                    data: dataCounts,
                    borderColor: '#3b82f6', // Warna garis biru Tailwind
                    borderWidth: 3,
                    pointBackgroundColor: '#3b82f6',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    tension: 0.35, // Membuat garis melengkung smooth (tidak patah-patah)
                    fill: true,
                    backgroundColor: gradient,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // Sembunyikan legend box agar lebih minimalis
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleFont: { family: 'Inter', size: 12 },
                        bodyFont: { family: 'Inter', size: 13, weight: 'bold' },
                        padding: 10,
                        cornerRadius: 8,
                        displayColors: false
                    }
                },
                scales: {
                    y: {
                        grid: {
                            color: '#f1f5f9',
                        },
                        ticks: {
                            color: '#94a3b8',
                            font: { family: 'Inter', size: 11 },
                            stepSize: 1 // Skala angka bulat bulat
                        },
                        border: {
                            dash: [5, 5] // Gridline putus-putus
                        }
                    },
                    x: {
                        grid: {
                            display: false // Hilangkan garis grid vertikal agar bersih
                        },
                        ticks: {
                            color: '#94a3b8',
                            font: { family: 'Inter', size: 11 }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection