@extends('template')

@section('title', 'Detail Invoice')

@section('content')

<div class="bg-slate-50 min-h-screen py-10 font-sans text-slate-800">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        {{-- HEADER PAGE --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8 gap-4">
            <div>
                <div class="flex items-center gap-2 text-sm text-slate-500 mb-1">
                    <a href="{{ route('invoice.index') }}" class="hover:text-indigo-600 transition-colors">Invoice</a>
                    <span>/</span>
                    <span class="text-slate-800 font-medium">Detail</span>
                </div>
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight">
                    {{ $invoice->nomor_invoice }}
                </h1>
                <p class="text-slate-500 text-sm mt-1">
                    Tanggal: {{ \Carbon\Carbon::parse($invoice->tanggal_invoice)->format('d F Y') }}
                </p>
            </div>
            
            <div class="flex gap-3">
                <a href="{{ route('invoice.index') }}" class="inline-flex items-center justify-center px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-medium text-slate-700 bg-white hover:bg-slate-50 transition-colors shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
                {{-- Contoh Tombol Cetak (Optional) --}}
                <button class="inline-flex items-center justify-center px-4 py-2.5 border border-transparent rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition-colors shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak
                </button>
            </div>
        </div>

        {{-- MAIN GRID --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- KIRI: DETAIL INFORMASI --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- INFORMASI INVOICE & CUSTOMER --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    {{-- Card Invoice Info --}}
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="font-semibold text-slate-800">Informasi Invoice</h3>
                        </div>
                        
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-medium text-slate-500 uppercase mb-1">Jenis Invoice</label>
                                <div class="p-2.5 bg-slate-50 rounded-lg border border-slate-200 text-slate-700 text-sm font-medium">
                                    {{ strtoupper($invoice->jenis_invoice) }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card Customer --}}
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <h3 class="font-semibold text-slate-800">Customer</h3>
                        </div>
                        <div class="p-3 bg-slate-50 border border-slate-200 rounded-lg">
                            <p class="text-lg font-medium text-slate-900">{{ $invoice->customer->nama_customer }}</p>
                        </div>
                    </div>

                </div>

                {{-- DELIVERY ORDER --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8M9 12h6" />
                            </svg> 
                            <h3 class="font-semibold text-slate-800">Delivery Order</h3> 
                        </div> 
                    </div>
                                    <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-50 text-slate-500 font-medium border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-3">No DO</th>
                                <th class="px-6 py-3">Customer</th>
                                <th class="px-6 py-3">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($invoice->deliveryOrders as $do)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-3 font-medium text-slate-900">{{ $do->nomor_do }}</td>
                                <td class="px-6 py-3 text-slate-600">{{ $do->customer->nama_customer }}</td>
                                <td class="px-6 py-3 text-slate-500">{{ \Carbon\Carbon::parse($do->tanggal_do)->format('d/m/Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-slate-400">Tidak ada DO</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- DETAIL ITEM --}}
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4m0-10l-8 4" />
                        </svg>
                        <h3 class="font-semibold text-slate-800">Detail Item</h3>
                    </div>
                    <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2.5 py-1 rounded-full">
                        {{ $invoice->details->count() }} Item
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-50 text-slate-500 font-medium border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-3">DO Ref</th>
                                <th class="px-6 py-3">Item Deskripsi</th>
                                <th class="px-6 py-3 text-center">Qty</th>
                                <th class="px-6 py-3 text-right">Harga Sat</th>
                                <th class="px-6 py-3 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($invoice->details as $detail)
                            <tr class="hover:bg-slate-50 transition-colors group">
                                <td class="px-6 py-3 font-medium text-slate-900">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700">
                                        {{ $detail->deliveryOrderDetail->deliveryOrder->nomor_do }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-slate-700">{{ $detail->salesOrderDetail->item->deskripsi }}</td>
                                <td class="px-6 py-3 text-center text-slate-600">{{ $detail->qty }}</td>
                                <td class="px-6 py-3 text-right text-slate-600">
                                    Rp {{ number_format($detail->harga,0,',','.') }}
                                </td>
                                <td class="px-6 py-3 text-right font-medium text-slate-900">
                                    Rp {{ number_format($detail->subtotal,0,',','.') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-slate-400">Tidak ada item</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        {{-- KANAN: RINGKASAN & PEMBAYARAN --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 sticky top-6">
                
                <div class="flex items-center gap-2 mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    <h3 class="font-semibold text-slate-800">Ringkasan</h3>
                </div>

                <div class="space-y-4">
                    {{-- DPP --}}
                    <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                        <span class="text-sm text-slate-500">DPP</span>
                        <span class="text-sm font-medium text-slate-700">Rp {{ number_format($invoice->total_dpp,0,',','.') }}</span>
                    </div>

                    {{-- PPN --}}
                    <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                        <span class="text-sm text-slate-500">PPN (10%)</span>
                        <span class="text-sm font-medium text-slate-700">Rp {{ number_format($invoice->ppn_total,0,',','.') }}</span>
                    </div>

                    {{-- Grand Total --}}
                    <div class="flex justify-between items-center pt-2">
                        <span class="text-base font-bold text-slate-900">Grand Total</span>
                        <span class="text-lg font-bold text-indigo-600">Rp {{ number_format($invoice->grand_total,0,',','.') }}</span>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-slate-200">
                    {{-- Status Bayar --}}
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="p-3 bg-emerald-50 rounded-lg border border-emerald-100">
                            <p class="text-xs font-medium text-emerald-600 mb-1">Dibayar</p>
                            <p class="text-sm font-bold text-emerald-700">Rp {{ number_format($totalDibayar,0,',','.') }}</p>
                        </div>
                        <div class="p-3 bg-amber-50 rounded-lg border border-amber-100">
                            <p class="text-xs font-medium text-amber-600 mb-1">Sisa</p>
                            <p class="text-sm font-bold text-amber-700">Rp {{ number_format($sisaTagihan,0,',','.') }}</p>
                        </div>
                    </div>

                    {{-- Progress Bar --}}
                    <div class="mb-6">
                        @php
                            $percent = $invoice->grand_total > 0 ? ($totalDibayar / $invoice->grand_total) * 100 : 0;
                        @endphp
                        <div class="flex justify-between text-xs mb-1">
                            <span class="text-slate-500">Pembayaran</span>
                            <span class="font-medium text-slate-700">{{ number_format($percent,1) }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                            <div class="bg-indigo-500 h-2 rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                        </div>
                    </div>

                    {{-- Form Pembayaran --}}
                    <form method="POST" action="{{ route('invoice.payment.store', $invoice->id) }}" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Nominal Pembayaran</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-slate-400 text-sm">Rp</span>
                                </div>
                                <input 
                                    type="number" 
                                    name="nominal_dp" 
                                    max="{{ $sisaTagihan }}"
                                    required
                                    class="w-full pl-10 pr-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all placeholder-slate-400"
                                    placeholder="0">
                            </div>
                            <p class="text-xs text-slate-400 mt-1.5 text-right">Max: Rp {{ number_format($sisaTagihan,0,',','.') }}</p>
                        </div>

                        <button 
                            type="submit" 
                            class="w-full flex justify-center items-center gap-2 py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Simpan Pembayaran
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection