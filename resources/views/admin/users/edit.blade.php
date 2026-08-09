@extends('layouts.admin')

@section('page_title', 'Edit Data Pengguna')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Edit Akun {{ $user->name }}</h2>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi profil atau peran akun pengguna.</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 font-medium">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="p-6 sm:p-8 space-y-6">
            @csrf
            @method('PUT')

            <!-- Input Nama -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required 
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Input Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required 
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Select Peran (Role) -->
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Peran Akun <span class="text-red-500">*</span></label>
                <select name="role" id="role" required
                    {{ $user->id === auth()->id() ? 'disabled' : '' }}
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 @error('role') border-red-500 @enderror">
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin (Akses Penuh Panel Admin)</option>
                    <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User (Pengguna Biasa)</option>
                </select>
                @if($user->id === auth()->id())
                    <input type="hidden" name="role" value="admin">
                    <p class="text-xs text-amber-600 mt-1">Anda tidak dapat mengubah peran akun Anda sendiri.</p>
                @endif
                @error('role')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-bold text-gray-900 mb-1">Ubah Kata Sandi (Opsional)</h3>
                <p class="text-sm text-gray-500 mb-4">Biarkan kosong jika Anda tidak ingin mengubah kata sandi akun ini.</p>

                <!-- Input Password Baru -->
                <div class="space-y-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi Baru</label>
                        <input type="password" name="password" id="password" minlength="8"
                            placeholder="Minimal 8 karakter"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" minlength="8"
                            placeholder="Ulangi kata sandi baru"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500">
                    </div>
                </div>
            </div>

            <!-- Tombol Action -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg text-sm transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg text-sm shadow transition flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Simpan Pembaruan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
