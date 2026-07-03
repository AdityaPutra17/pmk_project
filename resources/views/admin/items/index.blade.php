@extends('template')
@section('title', 'Item Management')

@section('content')
<!-- Page Background -->
<div class="bg-slate-50 min-h-screen p-6 md:p-8 font-sans text-slate-800">

    <div class="max-w-6xl mx-auto">

        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Item Management</h1>
                <p class="text-slate-500 text-sm mt-1">Kelola data item/barang.</p>
            </div>
            <button onclick="toggleForm()" type="button" class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl shadow-sm shadow-indigo-500/30 transition-all duration-200 hover:shadow-lg active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Item
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

        <!-- Form Add Item (Collapsible) -->
        <div id="add-form-card" class="bg-white rounded-2xl shadow-sm border border-slate-200 mb-8 hidden transform transition-all duration-300 ease-in-out">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50 rounded-t-2xl">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <h3 class="text-lg font-semibold text-slate-800">Item Baru</h3>
                </div>
                <button onclick="toggleForm()" class="text-slate-400 hover:text-slate-600 transition-colors p-1 rounded-lg hover:bg-slate-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <div class="p-6">
                <form action="{{ route('items.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <!-- Select Kategori -->
                        <div class="space-y-2">
                            <label for="category_id" class="block text-sm font-medium text-slate-700">Kategori</label>
                            <select name="category_id" id="category_id" required
                                class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 appearance-none">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }} ({{ $category->kd_category }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Input Harga -->
                        <div class="space-y-2">
                            <label for="harga" class="block text-sm font-medium text-slate-700">Harga</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-slate-400 text-sm font-medium">Rp</span>
                                </div>
                                <input type="number" name="harga" id="harga" step="0.01" required 
                                    class="block w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200"
                                    placeholder="0">
                            </div>
                        </div>

                        <!-- Select Satuan -->
                        <div class="space-y-2">
                            <label for="satuan" class="block text-sm font-medium text-slate-700">Satuan</label>
                            <select name="satuan" id="satuan" required
                                class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 appearance-none">
                                <option value="pcs">Pcs</option>
                                <option value="box">Box</option>
                                <option value="kg">Kg</option>
                                <option value="liter">Liter</option>
                                <option value="pack">Pack</option>
                            </select>
                        </div>

                        <!-- Input Deskripsi -->
                        <div class="space-y-2 md:col-span-2">
                            <label for="deskripsi" class="block text-sm font-medium text-slate-700">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" rows="3" 
                                class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200"
                                placeholder="Deskripsi produk..."></textarea>
                        </div>
                    </div>

                    <div class="flex items-center justify-end pt-2 gap-3">
                        <button type="button" onclick="toggleForm()" class="px-5 py-2.5 text-slate-600 hover:text-slate-800 font-medium text-sm transition-colors rounded-lg hover:bg-slate-100">Batal</button>
                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-lg shadow-indigo-500/30 transition-all duration-200 hover:-translate-y-0.5 active:scale-95">
                            Simpan Item
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-slate-800">Daftar Item</h3>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700">
                    {{ count($items) }} Items
                </span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 text-slate-500 text-xs uppercase tracking-wider font-semibold">
                            <th class="px-4 py-4 border-b border-slate-100 w-16"></th>
                            <th class="px-6 py-4 border-b border-slate-100">Kode Item</th>
                            <th class="px-6 py-4 border-b border-slate-100">Kategori</th>
                            <th class="px-6 py-4 border-b border-slate-100 hidden md:table-cell">Harga</th>
                            <th class="px-6 py-4 border-b border-slate-100 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                        @forelse($items as $item)
                        <tr class="hover:bg-slate-50/60 transition-colors group">
                            <td class="px-4 py-4">
                                <button onclick="toggleDetail({{ $item->id }})" class="w-7 h-7 rounded-full bg-slate-100 hover:bg-indigo-100 hover:text-indigo-600 flex items-center justify-center text-sm font-medium transition-colors">
                                    <span id="icon-{{ $item->id }}">+</span>
                                </button>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-medium text-slate-800">{{ $item->kd_item }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md bg-indigo-50 text-indigo-700 text-xs font-medium">
                                    {{ $item->category->kd_category }}
                                </span>
                                <span class="ml-2">{{ $item->category->name }}</span>
                            </td>
                            <td class="px-6 py-4 hidden md:table-cell">
                                <span class="font-medium text-slate-800">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                                <span class="text-xs text-slate-400">/{{ $item->satuan }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button 
                                        onclick='openEditModal(
                                            {{ $item->id }},
                                            @json($item->kd_item),
                                            @json($item->category_id),
                                            @json($item->harga),
                                            @json($item->satuan),
                                            @json($item->deskripsi)
                                        )'
                                        class="p-2 text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition-colors" 
                                        title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <form action="{{ route('items.destroy', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                            onclick="return confirm('Yakin ingin menghapus item {{ $item->kd_item }}?')"
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
                        <tr id="detail-{{ $item->id }}" class="hidden bg-slate-50/50">
                            <td colspan="5" class="px-6 py-4">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                    <div>
                                        <span class="font-semibold text-slate-500 text-xs uppercase">Kode Item</span>
                                        <p class="text-slate-800 font-medium">{{ $item->kd_item }}</p>
                                    </div>
                                    <div>
                                        <span class="font-semibold text-slate-500 text-xs uppercase">Kategori</span>
                                        <p class="text-slate-800">{{ $item->category->name }} ({{ $item->category->kd_category }})</p>
                                    </div>
                                    <div>
                                        <span class="font-semibold text-slate-500 text-xs uppercase">Harga</span>
                                        <p class="text-slate-800 font-medium">Rp {{ number_format($item->harga, 0, ',', '.') }} <span class="text-xs font-normal text-slate-400">/{{ $item->satuan }}</span></p>
                                    </div>
                                    <div class="md:col-span-2">
                                        <span class="font-semibold text-slate-500 text-xs uppercase">Deskripsi</span>
                                        <p class="text-slate-800">{{ $item->deskripsi ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                                                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                    <span class="text-sm font-medium">Belum ada data item.</span>
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
                    Menampilkan <span class="font-medium">{{ $items->firstItem() ?? 0 }}</span> hingga <span class="font-medium">{{ $items->lastItem() ?? 0 }}</span> dari <span class="font-medium">{{ $items->total() }}</span> data
                </div>
                <div>
                    {{ $items->links() }}
                </div>
            </div>
        </div>

    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden z-50 transition-opacity duration-300" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div id="modal-panel" class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg scale-95 opacity-0" onclick="event.stopPropagation()">
                    
                    <!-- Modal Header -->
                    <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-slate-800" id="modal-title">Edit Item</h3>
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
                                <!-- Kode Item (Readonly) -->
                                <div class="space-y-2 md:col-span-2">
                                    <label for="edit_kd_item" class="block text-sm font-medium text-slate-700">Kode Item</label>
                                    <input type="text" name="kd_item" id="edit_kd_item" readonly 
                                        class="block w-full px-4 py-2.5 bg-slate-100 border border-slate-200 rounded-xl text-slate-500 cursor-not-allowed">
                                </div>

                                <!-- Kategori -->
                                <div class="space-y-2">
                                    <label for="edit_category_id" class="block text-sm font-medium text-slate-700">Kategori</label>
                                    <select name="category_id" id="edit_category_id" required
                                        class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 appearance-none">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }} ({{ $category->kd_category }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Harga -->
                                <div class="space-y-2">
                                    <label for="edit_harga" class="block text-sm font-medium text-slate-700">Harga</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-slate-400 text-sm font-medium">Rp</span>
                                        </div>
                                        <input type="number" name="harga" id="edit_harga" step="0.01" required 
                                            class="block w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200">
                                    </div>
                                </div>

                                <!-- Satuan -->
                                <div class="space-y-2">
                                    <label for="edit_satuan" class="block text-sm font-medium text-slate-700">Satuan</label>
                                    <select name="satuan" id="edit_satuan" required
                                        class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 appearance-none">
                                        <option value="pcs">Pcs</option>
                                        <option value="box">Box</option>
                                        <option value="kg">Kg</option>
                                        <option value="liter">Liter</option>
                                        <option value="pack">Pack</option>
                                    </select>
                                </div>

                                <!-- Deskripsi -->
                                <div class="space-y-2 md:col-span-2">
                                    <label for="edit_deskripsi" class="block text-sm font-medium text-slate-700">Deskripsi</label>
                                    <textarea name="deskripsi" id="edit_deskripsi" rows="3" 
                                        class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200"></textarea>
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

    // Buka Modal Edit
    function openEditModal(id, kd_item, category_id, harga, satuan, deskripsi) {
        const modal = document.getElementById('editModal');
        const panel = document.getElementById('modal-panel');

        // Set nilai input
        document.getElementById('edit_kd_item').value = kd_item;
        document.getElementById('edit_category_id').value = category_id;
        document.getElementById('edit_harga').value = harga;
        document.getElementById('edit_satuan').value = satuan;
        document.getElementById('edit_deskripsi').value = deskripsi || '';

        // Set action form
        document.getElementById('editForm').action = `/items/${id}`;

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