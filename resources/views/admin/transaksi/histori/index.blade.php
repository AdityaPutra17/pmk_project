@extends('template')

@section('title','History Transaction')

@section('content')

<div class="min-h-screen bg-gray-50 py-8">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header & Search -->
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">
                    Riwayat Transaksi
                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    Detail histori pembayaran dan tagihan masuk.
                </p>
            </div>
            <div class="w-full sm:w-72">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <!-- Search Icon -->
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 sm:text-sm transition duration-150 ease-in-out shadow-sm" placeholder="Cari invoice atau user...">
                </div>
            </div>
        </div>

        <!-- Main Card Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-white">
                    <thead class="bg-white">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Invoice
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tipe
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nominal Sebelum
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Bayar
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nominal Sekarang
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                User
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($histories as $row)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                
                                <!-- Date -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($row->created_at)->format('d M Y') }}
                                    <div class="text-xs text-gray-400 mt-0.5">
                                        {{ \Carbon\Carbon::parse($row->created_at)->format('H:i') }}
                                    </div>
                                </td>

                                <!-- Invoice Number -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-medium text-blue-600 bg-blue-50 px-2 py-1 rounded">
                                        #{{ $row->nomor_invoice }}
                                    </span>
                                </td>

                                <!-- Type Badge -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($row->tipe_transaksi == 'create')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                            <svg class="mr-1.5 h-2 w-2 text-indigo-400" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3"/></svg>
                                            CREATE
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                            <svg class="mr-1.5 h-2 w-2 text-emerald-400" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3"/></svg>
                                            PAYMENT
                                        </span>
                                    @endif
                                </td>

                                <!-- Nominals (Right Aligned) -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-600 font-mono">
                                    {{ number_format($row->nominal_sebelum,0,',','.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold text-gray-900 font-mono">
                                    {{ number_format($row->nominal_bayar,0,',','.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-600 font-mono">
                                    {{ number_format($row->nominal_setelah,0,',','.') }}
                                </td>

                                <!-- Dynamic Status Badge -->
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @php
                                        $status = strtolower($row->status_setelah);
                                        $badgeClass = 'bg-gray-100 text-gray-800';
                                        
                                        if (strpos($status, 'sukses') !== false || strpos($status, 'lunas') !== false) {
                                            $badgeClass = 'bg-green-100 text-green-800';
                                        } elseif (strpos($status, 'pending') !== false || strpos($status, 'proses') !== false) {
                                            $badgeClass = 'bg-yellow-100 text-yellow-800';
                                        } elseif (strpos($status, 'gagal') !== false || strpos($status, 'cancel') !== false) {
                                            $badgeClass = 'bg-red-100 text-red-800';
                                        }
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badgeClass }}">
                                        {{ strtoupper($row->status_setelah) }}
                                    </span>
                                </td>

                                <!-- User -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-gradient-to-tr from-blue-500 to-indigo-500 flex items-center justify-center text-white text-xs font-bold mr-3">
                                            {{ strtoupper(substr($row->user_name, 0, 1)) }}
                                        </div>
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $row->user_name }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-16 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada transaksi</h3>
                                    <p class="mt-1 text-sm text-gray-500">Data histori transaksi kosong atau tidak ditemukan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($histories->hasPages())
                <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Menampilkan halaman <span class="font-medium">{{ $histories->currentPage() }}</span> dari <span class="font-medium">{{ $histories->lastPage() }}</span> Total <span class="font-medium">{{ $histories->total() }}</span> data.
                            </p>
                        </div>
                        <div>
                            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                {{ $histories->links() }}
                            </nav>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        
    </div>
</div>

@endsection