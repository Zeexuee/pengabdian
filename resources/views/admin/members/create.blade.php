@extends('layouts.admin')

@section('page_title', 'Tambah Anggota Baru')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('admin.members.index') }}" class="text-blue-600 hover:underline">&larr; Kembali ke Daftar</a>
</div>

<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <form action="{{ route('admin.members.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Input Nama -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required 
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                placeholder="Contoh: Budi Santoso">
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Input Posisi -->
        <div class="mb-4">
            <label for="position" class="block text-sm font-medium text-gray-700 mb-1">Jabatan <span class="text-red-500">*</span></label>
            <input type="text" name="position" id="position" value="{{ old('position') }}" required 
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                placeholder="Contoh: Ketua Umum">
            @error('position')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Input Urutan -->
        <div class="mb-4">
            <label for="order" class="block text-sm font-medium text-gray-700 mb-1">Urutan (Struktur) <span class="text-red-500">*</span></label>
            <input type="number" name="order" id="order" value="{{ old('order', 1) }}" min="1" required 
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                placeholder="Semakin kecil angka, semakin di atas (contoh: 1)">
            @error('order')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Input Bio -->
        <div class="mb-4">
            <label for="bio" class="block text-sm font-medium text-gray-700 mb-1">Bio / Deskripsi Singkat</label>
            <textarea name="bio" id="bio" rows="4" 
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                placeholder="Tuliskan biografi singkat anggota ini...">{{ old('bio') }}</textarea>
            @error('bio')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Input Foto -->
        <div class="mb-6">
            <label for="photo" class="block text-sm font-medium text-gray-700 mb-1">Upload Foto</label>
            <input type="file" name="photo" id="photo" accept="image/jpeg, image/png, image/webp" 
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            <p class="text-gray-500 text-xs mt-1">Format didukung: JPG, PNG, WEBP. Maks: 2MB.</p>
            @error('photo')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tombol Submit -->
        <div class="border-t pt-4 flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded shadow transition">
                Simpan Anggota
            </button>
        </div>
    </form>
</div>
@endsection
