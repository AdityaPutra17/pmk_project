@extends('template')
@section('title', 'Area Management')

@section('content')
<!-- Mengatur Background Halaman -->
<div class="bg-slate-50 min-h-screen p-6 md:p-8 font-sans text-slate-800">

    <!-- Container Utama dengan max-width -->
    <div class="max-w-5xl mx-auto">

        <!-- Bagian Header & Tombol Tambah -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Area Management</h1>
                <p class="text-slate-500 text-sm mt-1">Kelola data area operasional perusahaan.</p>
            </div>
            <button onclick="toggleForm()" type="button" class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl shadow-sm shadow-indigo-500/30 transition-all duration-200 hover:shadow-lg active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Area Baru
            </button>
        </div>

        <!-- Toast Notifikasi Sukses -->
        @if(session('success'))
        <div id="success-alert" class="fixed top-5 right-5 z-50 flex items-center gap-3 bg-white text-slate-700 px-5 py-4 rounded-xl shadow-xl border border-slate-100 transform transition-all duration-300 translate-y-[-4rem] opacity-0">
            <div class="bg-green-100 p-1.5 rounded-full text-green-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="flex flex-col">
                <span class="font-semibold text-sm">Berhasil!</span>
                <span class="text-xs text-slate-500">{{ session('success') }}</span>
            </div>
            <button onclick="closeAlert()" class="text-slate-400 hover:text-slate-600 ml-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <script>
            // Script khusus untuk menampilkan alert popup dengan animasi
            document.addEventListener('DOMContentLoaded', function() {
                const alert = document.getElementById('success-alert');
                if(alert) {
                    setTimeout(() => {
                        alert.classList.remove('translate-y-[-4rem]', 'opacity-0');
                    }, 100); // Sedikit delay agar trigger CSS transition
                    
                    setTimeout(() => {
                        alert.classList.add('translate-y-[-4rem]', 'opacity-0');
                        setTimeout(() => alert.remove(), 300);
                    }, 4000);
                }
            });
            function closeAlert() {
                const alert = document.getElementById('success-alert');
                if(alert) alert.remove();
            }
        </script>
        @endif

        <!-- Form Tambah (Collapsible Card) -->
        <div id="add-form-card" class="bg-white rounded-2xl shadow-sm border border-slate-200 mb-8 hidden transform transition-all duration-300 ease-in-out">
            <!-- Header Card Form -->
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50 rounded-t-2xl">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-slate-800">Formulir Area Baru</h3>
                </div>
                <button onclick="toggleForm()" class="text-slate-400 hover:text-slate-600 transition-colors p-1 rounded-lg hover:bg-slate-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <!-- Isi Form -->
            <div class="p-6">
                <form action="{{ route('area.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <!-- Input Nama Area -->
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-medium text-slate-700">Nama Area</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <input type="text" name="name" id="name" required 
                                    class="block w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200"
                                    placeholder="Contoh: Jakarta Selatan">
                            </div>
                        </div>

                        <!-- Input Kode Area -->
                        <div class="space-y-2">
                            <label for="kd_area" class="block text-sm font-medium text-slate-700">Kode Area</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                    </svg>
                                </div>
                                <input type="text" name="kd_area" id="kd_area" required 
                                    class="block w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 uppercase"
                                    placeholder="Ex: JKT">
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end pt-2 gap-3">
                        <button type="button" onclick="toggleForm()" class="px-5 py-2.5 text-slate-600 hover:text-slate-800 font-medium text-sm transition-colors rounded-lg hover:bg-slate-100">Batal</button>
                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-lg shadow-indigo-500/30 transition-all duration-200 hover:-translate-y-0.5 active:scale-95">
                            Simpan Area
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Search Section -->
        <div class="mb-8 bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <form method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                        class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all"
                        placeholder="Cari berdasarkan nama area atau kode area...">
                </div>
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-all">
                    Cari
                </button>
                @if($search)
                    <a href="{{ route('area.index') }}" class="px-6 py-2.5 bg-slate-300 hover:bg-slate-400 text-slate-800 font-medium rounded-lg transition-all">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Tabel Data Area -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-slate-800">Daftar Area</h3>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700">
                    {{ count($areas) }} Items
                </span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 text-slate-500 text-xs uppercase tracking-wider font-semibold">
                            <th class="px-6 py-4 border-b border-slate-100 w-20">No</th>
                            <th class="px-6 py-4 border-b border-slate-100">Nama Area</th>
                            <th class="px-6 py-4 border-b border-slate-100">Kode Area</th>
                            <th class="px-6 py-4 border-b border-slate-100 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                        @forelse($areas as $area)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="px-6 py-4 text-slate-400">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 font-medium text-slate-800">{{ $area->name }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md bg-slate-100 text-slate-600 text-xs font-bold tracking-wide uppercase">
                                    {{ $area->kd_area }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button 
                                        onclick="openEditModal({{ $area->id }}, '{{ $area->name }}', '{{ $area->kd_area }}')"
                                        class="p-2 text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition-colors" 
                                        title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <form action="{{ route('area.destroy', $area->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                            onclick="return confirm('Yakin ingin menghapus area {{ $area->name }}?')"
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
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    <span class="text-sm font-medium">Belum ada data area.</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <div class="text-sm text-slate-600">
                    Menampilkan <span class="font-medium">{{ $areas->firstItem() ?? 0 }}</span> hingga <span class="font-medium">{{ $areas->lastItem() ?? 0 }}</span> dari <span class="font-medium">{{ $areas->total() }}</span> data
                </div>
                <div>
                    {{ $areas->links() }}
                </div>
            </div>
        </div>
        
    </div> <!-- End Container -->

        <!-- Modal Edit (Hidden by default) -->
    <div id="editModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden z-50 transition-opacity duration-300" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Modal Panel -->
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div id="modal-panel" class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md scale-95 opacity-0" onclick="event.stopPropagation()">
                    
                    <!-- Modal Header -->
                    <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-slate-800" id="modal-title">Edit Area</h3>
                        <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 transition-colors p-1 rounded-lg hover:bg-slate-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Body (Form) -->
                    <div class="px-6 py-6">
                        <form id="editForm" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="space-y-4">
                                <!-- Nama Area -->
                                <div class="space-y-2">
                                    <label for="edit_name" class="block text-sm font-medium text-slate-700">Nama Area</label>
                                    <input type="text" name="name" id="edit_name" required 
                                        class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200">
                                </div>

                                <!-- Kode Area -->
                                <div class="space-y-2">
                                    <label for="edit_kd_area" class="block text-sm font-medium text-slate-700">Kode Area</label>
                                    <input type="text" name="kd_area" id="edit_kd_area" required 
                                        class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 uppercase">
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

<script>
    // 1. Toggle Form Tambah
    function toggleForm() {
        const formCard = document.getElementById('add-form-card');
        formCard.classList.toggle('hidden');
        
        // Animasi halus (Optional: bisa tambahkan class animasi di sini jika ingin)
        if (!formCard.classList.contains('hidden')) {
            formCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    // 2. Buka Modal Edit
    function openEditModal(id, name, kd_area) {
        const modal = document.getElementById('editModal');
        const panel = document.getElementById('modal-panel');

        // Set nilai input
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_kd_area').value = kd_area;

        // Set action form (route update)
        document.getElementById('editForm').action = `/area/${id}`;

        // Tampilkan modal (hapus hidden dan add opacity)
        modal.classList.remove('hidden');
        setTimeout(() => {
            panel.classList.remove('scale-95', 'opacity-0');
            panel.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    // 3. Tutup Modal Edit
    function closeEditModal() {
        const modal = document.getElementById('editModal');
        const panel = document.getElementById('modal-panel');

        // Animasi keluar
        panel.classList.remove('scale-100', 'opacity-100');
        panel.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300); // Tunggu selesai transisi
    }

    // Tutup modal jika klik di luar area (backdrop)
    document.getElementById('editModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeEditModal();
        }
    });
</script>
@endsection