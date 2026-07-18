@extends('template')
@section('title', 'Item PO Management')

@section('content')
<div class="bg-slate-50 min-h-screen p-6 md:p-8 font-sans text-slate-800">
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Item PO Management</h1>
                <p class="text-slate-500 text-sm mt-1">Kelola item PO dengan mudah.</p>
            </div>
            <button onclick="toggleForm()" type="button" class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl shadow-sm shadow-indigo-500/30 transition-all duration-200 hover:shadow-lg active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Item PO Baru
            </button>
        </div>

        {{-- Alert Notifikasi --}}
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

        {{-- Form Tambah Item --}}
        <div id="add-form-card" class="bg-white rounded-2xl shadow-sm border border-slate-200 mb-8 hidden transform transition-all duration-300 ease-in-out">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50 rounded-t-2xl">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-slate-800">Data Item PO Baru</h3>
                </div>
                <button onclick="toggleForm()" class="text-slate-400 hover:text-slate-600 transition-colors p-1 rounded-lg hover:bg-slate-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="p-6">
                <form action="{{ route('item-po.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-slate-700">Kode Item PO</label>
                            <input type="text" value="{{ $newItemCode }}" readonly class="block w-full px-4 py-2.5 bg-slate-100 border border-slate-200 rounded-xl text-slate-500 cursor-not-allowed">
                        </div>

                        <div class="space-y-2 md:col-span-2">
                            <label for="id_jenis_item_po" class="block text-sm font-medium text-slate-700">Jenis Item PO</label>
                            <select name="id_jenis_item_po" id="id_jenis_item_po" required class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200">
                                <option value="">Pilih jenis item PO</option>
                                @foreach($jenisItems as $jenisItem)
                                <option value="{{ $jenisItem->id }}">{{ $jenisItem->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-2 md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-slate-700">Deskripsi</label>
                            <textarea name="description" id="description" rows="3" required class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200" placeholder="Deskripsi item PO">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div class="flex items-center justify-end pt-2 gap-3">
                        <button type="button" onclick="toggleForm()" class="px-5 py-2.5 text-slate-600 hover:text-slate-800 font-medium text-sm transition-colors rounded-lg hover:bg-slate-100">Batal</button>
                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-lg shadow-indigo-500/30 transition-all duration-200 hover:-translate-y-0.5 active:scale-95">
                            Simpan Item PO
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Search Section -->
        <div class="mb-8 bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <form method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ $search ?? '' }}" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all" placeholder="Cari berdasarkan kode item atau deskripsi...">
                </div>
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-all">Cari</button>
                @if($search)
                    <a href="{{ route('item-po.index') }}" class="px-6 py-2.5 bg-slate-300 hover:bg-slate-400 text-slate-800 font-medium rounded-lg transition-all text-center">Reset</a>
                @endif
            </form>
        </div>

        {{-- Daftar Table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-slate-800">Daftar Item PO</h3>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700">
                    {{ $itemPOs->total() }} Item PO
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 text-slate-500 text-xs uppercase tracking-wider font-semibold">
                            <th class="px-6 py-4 border-b border-slate-100 w-16">#</th>
                            <th class="px-6 py-4 border-b border-slate-100">Kode Item PO</th>
                            <th class="px-6 py-4 border-b border-slate-100">Jenis Item</th>
                            <th class="px-6 py-4 border-b border-slate-100">Deskripsi</th>
                            <th class="px-6 py-4 border-b border-slate-100 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                        @forelse($itemPOs as $itemPO)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="px-6 py-4 text-slate-400">{{ ($itemPOs->currentPage()-1) * $itemPOs->perPage() + $loop->iteration }}</td>
                            <td class="px-6 py-4 font-medium text-slate-800">{{ $itemPO->item_code }}</td>
                            <td class="px-6 py-4">{{ $itemPO->itemType->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $itemPO->description }}</td>
                            <td class="px-6 py-4 text-right flex justify-end gap-2">
                                {{-- Tombol Edit --}}
                                <button type="button" 
                                    onclick="openEditModal({{ json_encode($itemPO) }})"
                                    class="p-2 text-amber-600 bg-amber-50 hover:bg-amber-100 rounded-lg transition-colors" 
                                    title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('item-po.destroy', $itemPO->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin ingin menghapus item PO ini?')" class="p-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                    <span class="text-sm font-medium">Belum ada data Item PO.</span>
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
                    Menampilkan <span class="font-medium">{{ $itemPOs->firstItem() ?? 0 }}</span> hingga <span class="font-medium">{{ $itemPOs->lastItem() ?? 0 }}</span> dari <span class="font-medium">{{ $itemPOs->total() }}</span> data
                </div>
                <div>
                    {{ $itemPOs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL MODAL EDIT --}}
<div id="edit-modal" class="fixed inset-0 z-[9999] overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0 relative">
        
        <!-- Background Overlay (Ditambahkan pointer-events dan z-index minus relatif terhadap content box) -->
        <div class="fixed inset-0 bg-slate-500/75 transition-opacity z-10" onclick="closeEditModal()"></div>

        <!-- Trik browser untuk centering alignment modal secara vertikal -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Modal Content Box (Diberikan z-index 20 agar melompat di atas overlay dan pointer-events-auto) -->
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-200 relative z-20 pointer-events-auto">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="text-lg font-semibold text-slate-800" id="modal-title">Edit Data Item PO</h3>
                <button type="button" onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 transition-colors p-1 rounded-lg hover:bg-slate-200">
                    ✕
                </button>
            </div>
            <form id="edit-form" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                
                <div class="space-y-1">
                    <label class="block text-sm font-medium text-slate-700">Kode Item PO</label>
                    <input type="text" id="edit_item_code" readonly class="block w-full px-4 py-2.5 bg-slate-100 border border-slate-200 rounded-xl text-slate-500 cursor-not-allowed">
                </div>

                <div class="space-y-1">
                    <label for="edit_id_jenis_item_po" class="block text-sm font-medium text-slate-700">Jenis Item PO</label>
                    <select name="id_jenis_item_po" id="edit_id_jenis_item_po" required class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                        @foreach($jenisItems as $jenisItem)
                        <option value="{{ $jenisItem->id }}">{{ $jenisItem->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-1">
                    <label for="edit_description" class="block text-sm font-medium text-slate-700">Deskripsi</label>
                    <textarea name="description" id="edit_description" rows="3" required class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500"></textarea>
                </div>

                <div class="flex items-center justify-end pt-3 gap-2 border-t border-slate-100">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 text-slate-600 hover:text-slate-800 font-medium text-sm rounded-lg hover:bg-slate-100">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm rounded-xl shadow-md transition-all">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleForm() {
        const formCard = document.getElementById('add-form-card');
        formCard.classList.toggle('hidden');
        if (!formCard.classList.contains('hidden')) {
            formCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    function openEditModal(itemPO) {
        const modal = document.getElementById('edit-modal');
        const form = document.getElementById('edit-form');
        
        // Sesuaikan endpoint action rute update Anda
        form.action = `/item-po/${itemPO.id}`;
        
        // Isi nilai input modal secara otomatis
        document.getElementById('edit_item_code').value = itemPO.item_code;
        document.getElementById('edit_id_jenis_item_po').value = itemPO.id_jenis_item_po;
        document.getElementById('edit_description').value = itemPO.description;
        
        // Tampilkan modal dan kunci body scroll jika diperlukan
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeEditModal() {
        document.getElementById('edit-modal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
</script>
@endsection