@extends('template')
@section('title', 'Customer Management')

@section('content')
<!-- Page Background -->
<div class="bg-slate-50 min-h-screen p-6 md:p-8 font-sans text-slate-800">

    <div class="max-w-7xl mx-auto">

        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Customer Management</h1>
                <p class="text-slate-500 text-sm mt-1">Kelola data pelanggan.</p>
            </div>
            <button onclick="toggleForm()" type="button" class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl shadow-sm shadow-indigo-500/30 transition-all duration-200 hover:shadow-lg active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Customer
            </button>
        </div>

        <!-- Notifications -->
        @if(session('error'))
        <div id="error-alert" class="fixed top-5 right-5 z-50 flex items-center gap-3 bg-white text-red-600 px-5 py-4 rounded-xl shadow-xl border border-red-100 animate-slide-in">
            <div class="bg-red-100 p-1.5 rounded-full text-red-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </div>
            <span class="text-sm font-medium">{{ session('error') }}</span>
            <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-700 ml-2">✕</button>
        </div>
        <script>setTimeout(() => document.getElementById('error-alert')?.remove(), 3000);</script>
        @endif

        @if(session('success'))
        <div id="success-alert" class="fixed top-5 right-5 z-50 flex items-center gap-3 bg-white text-slate-700 px-5 py-4 rounded-xl shadow-xl border border-slate-100 animate-slide-in">
            <div class="bg-green-100 p-1.5 rounded-full text-green-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="flex flex-col">
                <span class="font-semibold text-sm">Berhasil!</span>
                <span class="text-xs text-slate-500">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-slate-400 hover:text-slate-600 ml-2">✕</button>
        </div>
        <script>setTimeout(() => document.getElementById('success-alert')?.remove(), 4000);</script>
        @endif

        <!-- Form Add Customer (Collapsible) -->
        <div id="add-form-card" class="bg-white rounded-2xl shadow-sm border border-slate-200 mb-8 hidden transform transition-all duration-300 ease-in-out">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50 rounded-t-2xl">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-slate-800">Data Customer Baru</h3>
                </div>
                <button onclick="toggleForm()" class="text-slate-400 hover:text-slate-600 transition-colors p-1 rounded-lg hover:bg-slate-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <div class="p-6">
                <form action="{{ route('customers.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <!-- Input Nama Customer -->
                        <div class="space-y-2">
                            <label for="nama_customer" class="block text-sm font-medium text-slate-700">Nama Customer</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <input type="text" name="nama_customer" id="nama_customer" value="{{ old('nama_customer') }}" required 
                                    class="block w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200"
                                    placeholder="PT Indonesia Jaya">
                                @error('nama_customer')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Input NPWP -->
                        <div class="space-y-2">
                            <label for="npwp" class="block text-sm font-medium text-slate-700">NPWP</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z" />
                                    </svg>
                                </div>
                                <input type="text" name="npwp" id="npwp" value="{{ old('npwp') }}" required maxlength="16" pattern="[0-9]{16}" 
                                    class="block w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200"
                                    placeholder="1234567890123456">
                            </div>
                            <p class="text-xs text-slate-400">Wajib 16 digit angka</p>
                            @error('npwp')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Input Alamat -->
                        <div class="md:col-span-2 space-y-2">
                            <label for="alamat" class="block text-sm font-medium text-slate-700">Alamat Lengkap</label>
                            <textarea name="alamat" id="alamat" rows="3" required 
                                class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200"
                                placeholder="Jl. Sudirman No. 123, Jakarta Pusat">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Input No Telepon -->
                        <div class="space-y-2">
                            <label for="no_telp" class="block text-sm font-medium text-slate-700">Nomor Telepon</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.129a11.042 11.042 0 005.516 5.516l1.129-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 012.004-.51M21 15a2 2 0 01-2 2h-4l-3 3" />
                                    </svg>
                                </div>
                                <input type="text" name="no_telp" id="no_telp" value="{{ old('no_telp') }}" required 
                                    class="block w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200"
                                    placeholder="0812xxxx">
                            </div>
                            @error('no_telp')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Select Sales & Area -->
                        <div class="space-y-2">
                            <label for="sales_id" class="block text-sm font-medium text-slate-700">Sales</label>
                            <select name="sales_id" id="sales_id" onchange="setArea()" required
                                class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 appearance-none">
                                <option value="">-- Pilih Sales --</option>
                                @foreach($sales as $item)
                                    <option value="{{ $item->id }}" data-area="{{ $item->area->name ?? '-' }}" data-area-id="{{ $item->area_id }}" {{ old('sales_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label for="area_name" class="block text-sm font-medium text-slate-700">Area</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <input type="text" name="area_name" id="area_name" readonly 
                                    class="block w-full pl-11 pr-4 py-2.5 bg-slate-100 border border-slate-200 rounded-xl text-slate-500 cursor-not-allowed">
                                <input type="hidden" name="area_id" id="area_id">
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end pt-2 gap-3">
                                                <button type="button" onclick="toggleForm()" class="px-5 py-2.5 text-slate-600 hover:text-slate-800 font-medium text-sm transition-colors rounded-lg hover:bg-slate-100">Batal</button>
                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-lg shadow-indigo-500/30 transition-all duration-200 hover:-translate-y-0.5 active:scale-95">
                            Simpan Customer
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-slate-800">Daftar Customer</h3>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700">
                    {{ count($customers) }} Customer
                </span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 text-slate-500 text-xs uppercase tracking-wider font-semibold">
                            <th class="px-6 py-4 border-b border-slate-100 w-16">#</th>
                            <th class="px-6 py-4 border-b border-slate-100">Customer</th>
                            <th class="px-6 py-4 border-b border-slate-100 hidden md:table-cell">Kode</th>
                            <th class="px-6 py-4 border-b border-slate-100 hidden lg:table-cell">Sales</th>
                            <th class="px-6 py-4 border-b border-slate-100 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                        @forelse($customers as $customer)
                        <tr class="hover:bg-slate-50/60 transition-colors group">
                            <td class="px-6 py-4">
                                <button onclick="toggleDetail({{ $customer->id }})" class="w-7 h-7 rounded-full bg-slate-100 hover:bg-indigo-100 hover:text-indigo-600 flex items-center justify-center text-sm font-medium transition-colors">
                                    <span id="icon-{{ $customer->id }}">+</span>
                                </button>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-800">{{ $customer->nama_customer }}</div>
                                <div class="text-xs text-slate-400 md:hidden">{{ $customer->sales->name ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 hidden md:table-cell">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md bg-slate-100 text-slate-600 text-xs font-bold tracking-wide uppercase">
                                    {{ $customer->kd_customer }}
                                </span>
                            </td>
                            <td class="px-6 py-4 hidden lg:table-cell">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    {{ $customer->sales->name ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button 
                                        onclick='openEditModal(
                                            {{ $customer->id }},
                                            @json($customer->nama_customer),
                                            @json($customer->kd_customer),
                                            @json($customer->alamat),
                                            @json($customer->npwp),
                                            @json($customer->no_telp),
                                            {{ $customer->sales_id }},
                                            {{ $customer->area_id }},
                                            @json($customer->sales->name ?? "-"),
                                            @json($customer->area->name ?? "-")
                                        )'
                                        class="p-2 text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition-colors" 
                                        title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                            onclick="return confirm('Yakin ingin menghapus customer {{ $customer->nama_customer }}?')"
                                            class="p-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors" 
                                            title="Hapus">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>                        
                        </tr>

                        <!-- Detail Row (Expandable) -->
                        <tr id="detail-{{ $customer->id }}" class="hidden bg-slate-50/50">
                            <td colspan="5" class="px-6 py-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-sm">
                                    <div>
                                        <span class="font-semibold text-slate-500 text-xs uppercase">NPWP</span>
                                        <p class="text-slate-800 font-mono">{{ $customer->npwp }}</p>
                                    </div>
                                    <div>
                                        <span class="font-semibold text-slate-500 text-xs uppercase">Telepon</span>
                                        <p class="text-slate-800">{{ $customer->no_telp }}</p>
                                    </div>
                                    <div>
                                        <span class="font-semibold text-slate-500 text-xs uppercase">Sales</span>
                                        <p class="text-slate-800">{{ $customer->sales->name ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <span class="font-semibold text-slate-500 text-xs uppercase">Area</span>
                                        <p class="text-slate-800">{{ $customer->area->name ?? 'N/A' }}</p>
                                    </div>
                                    <div class="md:col-span-2 lg:col-span-1">
                                        <span class="font-semibold text-slate-500 text-xs uppercase">Alamat</span>
                                        <p class="text-slate-800">{{ $customer->alamat }}</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <span class="text-sm font-medium">Belum ada data customer.</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden z-50 transition-opacity duration-300" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div id="modal-panel" class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl scale-95 opacity-0" onclick="event.stopPropagation()">
                    
                    <!-- Modal Header -->
                    <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-slate-800" id="modal-title">Edit Customer</h3>
                        <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 transition-colors p-1 rounded-lg hover:bg-slate-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="px-6 py-6">
                        <form id="editForm" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Nama Customer -->
                                <div class="space-y-2">
                                    <label for="edit_nama_customer" class="block text-sm font-medium text-slate-700">Nama Customer</label>
                                    <input type="text" name="nama_customer" id="edit_nama_customer" required 
                                        class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200">
                                </div>

                                <!-- Kode Customer -->
                                <div class="space-y-2">
                                    <label for="edit_kd_customer" class="block text-sm font-medium text-slate-700">Kode Customer</label>
                                    <input type="text" name="kd_customer" id="edit_kd_customer" readonly 
                                        class="block w-full px-4 py-2.5 bg-slate-100 border border-slate-200 rounded-xl text-slate-500 cursor-not-allowed">
                                </div>

                                <!-- Alamat -->
                                <div class="md:col-span-2 space-y-2">
                                    <label for="edit_alamat" class="block text-sm font-medium text-slate-700">Alamat</label>
                                    <textarea name="alamat" id="edit_alamat" rows="3" required 
                                        class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200"></textarea>
                                </div>

                                <!-- NPWP -->
                                <div class="space-y-2">
                                    <label for="edit_npwp" class="block text-sm font-medium text-slate-700">NPWP</label>
                                    <input type="text" name="npwp" id="edit_npwp" required maxlength="16" 
                                        class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200">
                                </div>

                                <!-- No Telepon -->
                                <div class="space-y-2">
                                    <label for="edit_no_telp" class="block text-sm font-medium text-slate-700">Telepon</label>
                                    <input type="text" name="no_telp" id="edit_no_telp" required 
                                        class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200">
                                </div>

                                <!-- Sales -->
                                <div class="space-y-2">
                                    <label for="edit_sales_id" class="block text-sm font-medium text-slate-700">Sales</label>
                                    <select name="sales_id" id="edit_sales_id" onchange="setEditArea()" required
                                        class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 appearance-none">
                                        <option value="">-- Pilih Sales --</option>
                                        @foreach($sales as $item)
                                            <option value="{{ $item->id }}" data-area="{{ $item->area->name ?? '-' }}" data-area-id="{{ $item->area_id }}">
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Area -->
                                <div class="space-y-2">
                                    <label for="edit_area_name" class="block text-sm font-medium text-slate-700">Area</label>
                                    <input type="text" name="area_name" id="edit_area_name" readonly 
                                        class="block w-full px-4 py-2.5 bg-slate-100 border border-slate-200 rounded-xl text-slate-500 cursor-not-allowed">
                                    <input type="hidden" name="area_id" id="edit_area_id">
                                </div>
                            </div>

                            <!-- Modal Footer -->
                            <div class="mt-6 flex items-center justify-end gap-3">
                                <button type="button" onclick="closeEditModal()" class="w-full px-4 py-2.5 text-slate-600 hover:text-slate-800 font-medium text-sm text-center border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors">Batal</button>
                                <button type="submit" class="w-full px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-md shadow-indigo-500/20 transition-all duration-200 hover:-translate-y-0.5">
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- JavaScript -->
<script>
    // Toggle Form Tambah
    function toggleForm() {
        const formCard = document.getElementById('add-form-card');
        formCard.classList.toggle('hidden');
        if (!formCard.classList.contains('hidden')) {
            formCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

       // Set Area saat pilih Sales (Form Tambah)
    function setArea() {
        const salesSelect = document.getElementById('sales_id');
        const selectedOption = salesSelect.options[salesSelect.selectedIndex];
        const areaName = selectedOption.getAttribute('data-area');
        const areaId = selectedOption.getAttribute('data-area-id');

        document.getElementById('area_name').value = areaName || '-';
        document.getElementById('area_id').value = areaId || '';
    }

    // Set Area saat pilih Sales (Modal Edit)
    function setEditArea() {
        const salesSelect = document.getElementById('edit_sales_id');
        const selectedOption = salesSelect.options[salesSelect.selectedIndex];
        const areaName = selectedOption.getAttribute('data-area');
        const areaId = selectedOption.getAttribute('data-area-id');

        document.getElementById('edit_area_name').value = areaName || '-';
        document.getElementById('edit_area_id').value = areaId || '';
    }

    // Buka Modal Edit
    function openEditModal(id, nama, kd, alamat, npwp, telp, salesId, areaId, salesName, areaName) {
        const modal = document.getElementById('editModal');
        const panel = document.getElementById('modal-panel');

        // Set nilai input
        document.getElementById('edit_nama_customer').value = nama;
        document.getElementById('edit_kd_customer').value = kd;
        document.getElementById('edit_alamat').value = alamat;
        document.getElementById('edit_npwp').value = npwp;
        document.getElementById('edit_no_telp').value = telp;
        document.getElementById('edit_sales_id').value = salesId;
        document.getElementById('edit_area_id').value = areaId;
        document.getElementById('edit_area_name').value = areaName;

        // Set action form
        document.getElementById('editForm').action = `/customers/${id}`;

        // Tampilkan modal
        modal.classList.remove('hidden');
        setTimeout(() => {
            panel.classList.remove('scale-95', 'opacity-0');
            panel.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    // Tutup Modal Edit
    function closeEditModal() {
        const modal = document.getElementById('editModal');
        const panel = document.getElementById('modal-panel');

        panel.classList.remove('scale-100', 'opacity-100');
        panel.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    // Tutup modal jika klik di luar area
    document.getElementById('editModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeEditModal();
        }
    });

    // Toggle Detail Row
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
</script>
@endsection