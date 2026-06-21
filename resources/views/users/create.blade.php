@extends('template')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 py-10 px-4">

    <div class="max-w-2xl mx-auto">

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-800">
                Tambah User
            </h1>

            <p class="text-slate-500 mt-2">
                Tambahkan pengguna baru dan tentukan role aksesnya.
            </p>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden">

            <!-- Top Gradient -->
            <div class="h-2 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500"></div>

            <form action="{{ route('users.store') }}" method="POST" class="p-8">
                @csrf

                <!-- Nama -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        name="name"
                        placeholder="Masukkan nama lengkap"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3
                               focus:outline-none focus:ring-4
                               focus:ring-blue-100 focus:border-blue-500
                               transition duration-200">
                </div>

                <!-- Email -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        placeholder="contoh@email.com"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3
                               focus:outline-none focus:ring-4
                               focus:ring-blue-100 focus:border-blue-500
                               transition duration-200">
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        placeholder="••••••••"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3
                               focus:outline-none focus:ring-4
                               focus:ring-blue-100 focus:border-blue-500
                               transition duration-200">
                </div>

                <!-- Role -->
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Role User
                    </label>

                    <select
                        name="role"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3
                               focus:outline-none focus:ring-4
                               focus:ring-blue-100 focus:border-blue-500
                               transition duration-200">

                        <option value="">Pilih Role</option>
                        <option value="admin">Admin</option>
                        <option value="manager">Manager</option>
                        <option value="staff">Staff</option>
                    </select>
                </div>

                <!-- Button -->
                <div class="flex items-center justify-end gap-3">

                    <a href="{{ route('users.index') }}"
                       class="px-5 py-3 rounded-xl border border-slate-300
                              text-slate-700 hover:bg-slate-100 transition">
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="px-6 py-3 rounded-xl
                               bg-gradient-to-r
                               from-blue-600
                               to-indigo-600
                               text-white
                               font-semibold
                               shadow-lg
                               hover:shadow-xl
                               hover:scale-[1.02]
                               transition duration-200">

                        Simpan User
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection