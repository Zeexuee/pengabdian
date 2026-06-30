@extends('layouts.admin')

@section('page_title', 'Edit Program Kerja')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('admin.work-programs.index') }}" class="text-blue-600 hover:underline">&larr; Kembali ke Daftar</a>
</div>

<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <form action="{{ route('admin.work-programs.update', $work_program->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Input Judul -->
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Program <span class="text-red-500">*</span></label>
            <input type="text" name="title" id="title" value="{{ old('title', $work_program->title) }}" required 
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            @error('title')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Input Tanggal Pelaksanaan -->
        <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" id="start_date" 
                    value="{{ old('start_date', $work_program->start_date ? $work_program->start_date->format('Y-m-d') : '') }}" 
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                @error('start_date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                <input type="date" name="end_date" id="end_date" 
                    value="{{ old('end_date', $work_program->end_date ? $work_program->end_date->format('Y-m-d') : '') }}" 
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                @error('end_date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Input Status -->
        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status Pelaksanaan <span class="text-red-500">*</span></label>
            <select name="status" id="status" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <option value="planned" {{ old('status', $work_program->status) === 'planned' ? 'selected' : '' }}>Direncanakan (Planned)</option>
                <option value="ongoing" {{ old('status', $work_program->status) === 'ongoing' ? 'selected' : '' }}>Sedang Berjalan (Ongoing)</option>
                <option value="completed" {{ old('status', $work_program->status) === 'completed' ? 'selected' : '' }}>Selesai (Completed)</option>
            </select>
            @error('status')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Input Deskripsi -->
        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Detail <span class="text-red-500">*</span></label>
            <textarea name="description" id="description" rows="5" required 
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('description', $work_program->description) }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Input Foto/Gambar Cover -->
        <div class="mb-6">
            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Gambar / Cover Saat Ini</label>
            
            @if($work_program->image)
                <div class="mb-3">
                    <img src="{{ Storage::url($work_program->image) }}" alt="{{ $work_program->title }}" class="w-48 h-32 object-cover rounded shadow-md border border-gray-200">
                </div>
            @else
                <p class="text-sm text-gray-500 italic mb-3">Belum ada gambar yang diunggah.</p>
            @endif

            <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Ganti/Upload Gambar Baru</label>
            <input type="file" name="image" id="image" accept="image/jpeg, image/png, image/webp" 
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            <p class="text-gray-500 text-xs mt-1">Biarkan kosong jika tidak ingin mengubah gambar. Format: JPG, PNG, WEBP (Max: 2MB).</p>
            @error('image')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tombol Submit -->
        <div class="border-t pt-4 flex justify-end space-x-3">
            <a href="{{ route('admin.work-programs.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-2 px-6 rounded shadow transition">
                Batal
            </a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded shadow transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
