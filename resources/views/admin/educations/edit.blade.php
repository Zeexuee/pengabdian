@extends('layouts.admin')

@section('page_title', 'Edit Materi Edukasi')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('admin.educations.index') }}" class="text-blue-600 hover:underline">&larr; Kembali ke Daftar</a>
</div>

<div class="bg-white rounded-lg shadow p-6 max-w-4xl mx-auto">
    <form action="{{ route('admin.educations.update', $education->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Kolom Kiri: Input Teks Utama -->
            <div class="md:col-span-2 space-y-4">
                
                <!-- Input Judul -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Materi <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title', $education->title) }}" required 
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input Konten / Artikel -->
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Isi Artikel Edukasi <span class="text-red-500">*</span></label>
                    <textarea name="content" id="content_editor" rows="10" required 
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('content', $education->content) }}</textarea>
                    @error('content')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- Kolom Kanan: Pengaturan Ekstra & Media -->
            <div class="space-y-4">
                
                <!-- Input Video URL -->
                <div>
                    <label for="video_url" class="block text-sm font-medium text-gray-700 mb-1">Tautan Video Youtube (Opsional)</label>
                    <input type="url" name="video_url" id="video_url" value="{{ old('video_url', $education->video_url) }}" 
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('video_url')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input Thumbnail -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <label class="block text-sm font-bold text-gray-700 mb-3">Thumbnail Saat Ini</label>
                    
                    @if($education->thumbnail)
                        <div class="mb-4">
                            <img src="{{ Storage::url($education->thumbnail) }}" alt="{{ $education->title }}" class="w-full h-auto object-cover rounded shadow-md">
                        </div>
                    @else
                        <p class="text-sm text-gray-500 italic mb-4">Belum ada thumbnail.</p>
                    @endif

                    <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-1">Ganti/Upload Baru</label>
                    <input type="file" name="thumbnail" id="thumbnail" accept="image/*" 
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm file:mr-2 file:py-2 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="text-gray-500 text-xs mt-1">Biarkan kosong jika tidak diganti.</p>
                    @error('thumbnail')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pengaturan Publikasi -->
                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <label for="is_published" class="block text-sm font-bold text-gray-800 mb-2">Status Publikasi <span class="text-red-500">*</span></label>
                    <select name="is_published" id="is_published" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="1" {{ old('is_published', $education->is_published) == '1' ? 'selected' : '' }}>Publikasikan (Tampil di Publik)</option>
                        <option value="0" {{ old('is_published', $education->is_published) == '0' ? 'selected' : '' }}>Simpan sebagai Draf (Sembunyikan)</option>
                    </select>
                    @error('is_published')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Submit -->
                <div class="mt-6 pt-4 border-t">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded shadow transition">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    ClassicEditor.create(document.querySelector('#content_editor')).catch(error => { console.error(error); });
</script>
@endpush
@endsection
