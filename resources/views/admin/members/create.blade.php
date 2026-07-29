@extends('layouts.admin')

@section('page_title', 'Tambah Anggota Baru')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('admin.members.index') }}" class="text-red-600 hover:underline">&larr; Kembali ke Daftar</a>
</div>

<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <form action="{{ route('admin.members.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Input Nama -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required 
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm"
                placeholder="Contoh: Budi Santoso">
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Input Posisi -->
        <div class="mb-4">
            <label for="position" class="block text-sm font-medium text-gray-700 mb-1">Jabatan <span class="text-red-500">*</span></label>
            <input type="text" name="position" id="position" value="{{ old('position') }}" required 
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm"
                placeholder="Contoh: Ketua Umum, Anggota Divisi">
            @error('position')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Input Divisi (Select dari tabel Divisions) -->
        <div class="mb-4">
            <div class="flex justify-between items-center mb-1">
                <label for="division_id" class="block text-sm font-medium text-gray-700">Divisi / Departemen <span class="text-red-500">*</span></label>
                <a href="{{ route('admin.divisions.create') }}" target="_blank" class="text-xs text-red-600 hover:underline font-semibold">+ Tambah Divisi Baru</a>
            </div>
            <select name="division_id" id="division_id" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm">
                <option value="">-- Pilih Divisi --</option>
                @foreach($divisions as $div)
                    <option value="{{ $div->id }}" {{ old('division_id') == $div->id ? 'selected' : '' }}>
                        {{ $div->name }}
                    </option>
                @endforeach
            </select>
            @if($divisions->isEmpty())
                <p class="text-amber-600 text-xs mt-1">Belum ada divisi terdaftar. Silakan buat divisi baru terlebih dahulu melalui menu Kelola Divisi.</p>
            @endif
            @error('division_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Input Urutan -->
        <div class="mb-4">
            <label for="order" class="block text-sm font-medium text-gray-700 mb-1">Urutan (Struktur) <span class="text-red-500">*</span></label>
            <input type="number" name="order" id="order" value="{{ old('order', 1) }}" min="1" required 
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm"
                placeholder="Semakin kecil angka, semakin di atas (contoh: 1)">
            @error('order')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Input Bio -->
        <div class="mb-4">
            <label for="bio" class="block text-sm font-medium text-gray-700 mb-1">Bio / Deskripsi Singkat</label>
            <textarea name="bio" id="bio" rows="4" 
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm"
                placeholder="Tuliskan biografi singkat anggota ini...">{{ old('bio') }}</textarea>
            @error('bio')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Input Foto -->
        <div class="mb-6">
            <label for="photo" class="block text-sm font-medium text-gray-700 mb-1">Upload Foto</label>
            <input type="file" name="photo" id="photo" accept="image/jpeg, image/png, image/webp" 
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
            <p class="text-gray-500 text-xs mt-1">Format didukung: JPG, PNG, WEBP. Maks: 2MB.</p>
            @error('photo')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tombol Submit -->
        <div class="border-t pt-4 flex justify-end">
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-6 rounded shadow transition">
                Simpan Anggota
            </button>
        </div>
    </form>
</div>
@endsection
