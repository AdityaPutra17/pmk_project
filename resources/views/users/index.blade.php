@extends('template')

@section('title', 'User Management')

@section('content')

<div class="bg-slate-50 min-h-screen p-6 md:p-8 font-sans text-slate-800">

    <div class="max-w-6xl mx-auto">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Users Management</h1>
                <p class="text-slate-500 text-sm mt-1">Kelola seluruh pengguna dan hak akses sistem.</p>
            </div>
            <button onclick="toggleAddUserForm()" type="button" class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl shadow-sm shadow-indigo-500/30 transition-all duration-200 hover:shadow-lg active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah User
            </button>
        </div>

        @if(session('success'))
        <div id="success-alert" class="mb-6 rounded-2xl border border-slate-200 bg-white px-6 py-4 shadow-sm text-slate-700">
            <div class="flex items-start gap-3">
                <div class="mt-0.5 text-green-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold">Berhasil</p>
                    <p class="text-sm text-slate-500">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div id="error-alert" class="mb-6 rounded-2xl border border-slate-200 bg-white px-6 py-4 shadow-sm text-red-700">
            <div class="flex items-start gap-3">
                <div class="mt-0.5 text-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold">Gagal</p>
                    <p class="text-sm text-slate-500">{{ session('error') }}</p>
                </div>
            </div>
        </div>
        @endif

        <div id="addUserCard" class="bg-white rounded-2xl shadow-sm border border-slate-200 mb-8 hidden transition-all duration-300">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50 rounded-t-2xl">
                <div>
                    <h3 class="text-lg font-semibold text-slate-800">Tambah User Baru</h3>
                    <p class="text-sm text-slate-500">Isi data user untuk menambahkan akun baru.</p>
                </div>
                <button onclick="toggleAddUserForm()" class="text-slate-400 hover:text-slate-600 rounded-lg p-2 hover:bg-slate-200 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-6">
                <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-slate-700">Nama</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required class="mt-2 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-700 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20" placeholder="Budi Santoso">
                            @error('name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required class="mt-2 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-700 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20" placeholder="user@domain.com">
                            @error('email')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                            <input type="password" name="password" id="password" required class="mt-2 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-700 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20" placeholder="Minimal 6 karakter">
                            @error('password')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="role" class="block text-sm font-medium text-slate-700">Role</label>
                            <select name="role" id="role" required class="mt-2 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-700 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20">
                                <option value="">Pilih role</option>
                                <option value="admin" {{ old('role')=='admin' ? 'selected' : '' }}>Admin</option>
                                <option value="manager" {{ old('role')=='manager' ? 'selected' : '' }}>Manager</option>
                                <option value="staff" {{ old('role')=='staff' ? 'selected' : '' }}>Staff</option>
                            </select>
                            @error('role')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row items-center justify-between gap-3 pt-2">
                        <button type="button" onclick="toggleAddUserForm()" class="w-full md:w-auto px-5 py-3 rounded-2xl border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 transition">Batal</button>
                        <button type="submit" class="w-full md:w-auto px-5 py-3 rounded-2xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition">Simpan User</button>
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
                        placeholder="Cari berdasarkan nama, email, atau role...">
                </div>
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-all">
                    Cari
                </button>
                @if($search)
                    <a href="{{ route('users.index') }}" class="px-6 py-2.5 bg-slate-300 hover:bg-slate-400 text-slate-800 font-medium rounded-lg transition-all">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-slate-800">Daftar User</h3>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700">
                    {{ $users->count() }} User
                </span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 text-slate-500 text-xs uppercase tracking-wider font-semibold">
                            <th class="px-6 py-4 border-b border-slate-100 w-14">#</th>
                            <th class="px-6 py-4 border-b border-slate-100">Nama</th>
                            <th class="px-6 py-4 border-b border-slate-100">Email</th>
                            <th class="px-6 py-4 border-b border-slate-100">Role</th>
                            <th class="px-6 py-4 border-b border-slate-100 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="userTable" class="divide-y divide-slate-100 text-sm text-slate-600">
                        @forelse($users as $user)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="px-6 py-4 text-slate-400">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 font-medium text-slate-800">{{ $user->name }}</td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                @if($user->role == 'admin')
                                    <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">Admin</span>
                                @elseif($user->role == 'manager')
                                    <span class="inline-flex items-center rounded-full bg-purple-100 px-3 py-1 text-xs font-semibold text-purple-700">Manager</span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Staff</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    {{-- <a href="{{ route('users.edit', $user->id) }}" class="inline-flex items-center justify-center rounded-lg border border-amber-100 bg-amber-50 px-3 py-2 text-amber-700 hover:bg-amber-100 transition">Edit</a> --}}
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Yakin ingin menghapus user ini?')" class="inline-flex items-center justify-center rounded-lg border border-red-100 bg-red-50 px-3 py-2 text-red-700 hover:bg-red-100 transition">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                Belum ada data user.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <div class="text-sm text-slate-600">
                    Menampilkan <span class="font-medium">{{ $users->firstItem() ?? 0 }}</span> hingga <span class="font-medium">{{ $users->lastItem() ?? 0 }}</span> dari <span class="font-medium">{{ $users->total() }}</span> data
                </div>
                <div>
                    {{ $users->links() }}
                </div>
            </div>
        </div>

    </div>

</div>

<script>
    function toggleAddUserForm() {
        const card = document.getElementById('addUserCard');
        card.classList.toggle('hidden');
    }

    document.getElementById('searchUser').addEventListener('keyup', function() {
        const value = this.value.toLowerCase();
        document.querySelectorAll('#userTable tr').forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
        });
    });
</script>

@endsection
