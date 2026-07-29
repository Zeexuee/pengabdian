@extends('layouts.admin')

@section('page_title', 'Edit Divisi & Hero Banner')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('admin.divisions.index') }}" class="text-red-600 hover:underline font-semibold">&larr; Kembali ke Daftar Divisi</a>
</div>

<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <form action="{{ route('admin.divisions.update', $division->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Input Nama Divisi -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Divisi / Departemen <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name', $division->name) }}" required 
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm">
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Input Deskripsi Singkat -->
        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat Divisi</label>
            <textarea name="description" id="description" rows="3" 
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm">{{ old('description', $division->description) }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Input Hero Banner Image -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Hero Banner Saat Ini</label>
            @if($division->banner_image)
                <div class="mb-3">
                    <img src="{{ Storage::url($division->banner_image) }}" alt="{{ $division->name }}" class="w-full max-h-48 object-cover rounded shadow-md border border-gray-200">
                </div>
            @else
                <p class="text-sm text-gray-500 italic mb-3">Belum ada gambar Hero Banner yang diunggah.</p>
            @endif

            <label for="banner_image" class="block text-sm font-medium text-gray-700 mb-1">Ganti / Upload Hero Banner Baru</label>
            <input type="file" name="banner_image" id="banner_image" accept="image/jpeg, image/png, image/webp" 
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
            <p class="text-gray-500 text-xs mt-1">Biarkan kosong jika tidak ingin mengganti banner. Format: JPG, PNG, WEBP (Max: 3MB).</p>
            @error('banner_image')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tombol Submit -->
        <div class="border-t pt-4 flex justify-end space-x-3">
            <a href="{{ route('admin.divisions.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-2 px-6 rounded shadow transition">
                Batal
            </a>
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-6 rounded shadow transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
