@extends('layouts.admin')

@section('page_title', 'Edit Komponen Beranda')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.home-sections.index') }}" class="text-red-600 hover:underline flex items-center">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Daftar
    </a>
</div>

<form action="{{ route('admin.home-sections.update', $homeSection->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 max-w-4xl">
    @csrf
    @method('PUT')

    <div class="bg-white p-6 border rounded-lg shadow-sm">
        
        @if(str_starts_with($homeSection->type, 'system_') || $homeSection->type === 'hero')
            <div class="p-4 mb-6 bg-amber-50 border-l-4 border-amber-500 rounded text-amber-900 text-sm">
                <p class="font-bold flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Komponen Bawaan Sistem
                </p>
                <p class="mt-1">Anda dapat menyesuaikan Judul Utama, Subjudul/Deskripsi Singkat, dan status aktifnya di sini.</p>
            </div>
        @endif

        <!-- Tipe Komponen -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Komponen <span class="text-red-500">*</span></label>
            <select name="type" id="type_selector" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 p-2 border bg-gray-100" required>
                <option value="{{ $homeSection->type }}">{{ strtoupper(str_replace(['system_', '_'], ['', ' '], $homeSection->type)) }}</option>
            </select>
            <p class="text-xs text-gray-500 mt-1">Tipe komponen tidak dapat diubah setelah dibuat. Buat komponen baru jika ingin tipe berbeda.</p>
        </div>

        <hr class="my-6">

        <!-- Fields Dinamis -->
        <div class="space-y-6">
            
            <!-- Judul -->
            <div class="field-group" data-show-for="text,image_text,video,callout,faq,hero,system_program_kerja,system_produk,system_edukasi,system_berita">
                <label class="block text-sm font-medium text-gray-700 mb-2">Judul Komponen (Opsional)</label>
                <input type="text" name="title" value="{{ old('title', $homeSection->title) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 p-2 border">
                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Gambar -->
            <div class="field-group" data-show-for="image,image_text">
                <label class="block text-sm font-medium text-gray-700 mb-2">Gambar</label>
                @if($homeSection->image)
                    <div class="mb-3">
                        <p class="text-sm text-gray-500 mb-1">Gambar saat ini:</p>
                        <img src="{{ asset('storage/' . $homeSection->image) }}" class="h-32 object-cover rounded border">
                    </div>
                @endif
                <input type="file" name="image" accept="image/*" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 p-2 border">
                <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah gambar.</p>
                @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Posisi Gambar (Hanya Image Text) -->
            <div class="field-group" data-show-for="image_text">
                <label class="block text-sm font-medium text-gray-700 mb-2">Posisi Gambar</label>
                <select name="image_position" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 p-2 border">
                    <option value="left" {{ old('image_position', $homeSection->image_position) == 'left' ? 'selected' : '' }}>Kiri</option>
                    <option value="right" {{ old('image_position', $homeSection->image_position) == 'right' ? 'selected' : '' }}>Kanan</option>
                </select>
            </div>

            <!-- Video URL -->
            <div class="field-group" data-show-for="video">
                <label class="block text-sm font-medium text-gray-700 mb-2">URL Video</label>
                <input type="url" name="video_url" value="{{ old('video_url', $homeSection->video_url) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 p-2 border">
                @error('video_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Konten (Teks / Subjudul) -->
            <div class="field-group" data-show-for="text,image_text,callout,faq,system_program_kerja,system_produk,system_edukasi,system_berita">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    {{ str_starts_with($homeSection->type, 'system_') ? 'Subjudul / Deskripsi Singkat Section' : 'Konten / Isi Teks' }}
                </label>
                <textarea name="content" id="content_editor" rows="5" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 p-2 border">{{ old('content', $homeSection->content) }}</textarea>
                @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Tombol Aksi (Image Text & Callout) -->
            <div class="field-group grid grid-cols-2 gap-4" data-show-for="image_text,callout">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Teks Tombol (Opsional)</label>
                    <input type="text" name="button_text" value="{{ old('button_text', $homeSection->button_text) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 p-2 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Link Tombol (Opsional)</label>
                    <input type="text" name="button_link" value="{{ old('button_link', $homeSection->button_link) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 p-2 border">
                </div>
            </div>

        </div>

        <hr class="my-6">

        <div class="mb-6">
            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500" {{ old('is_active', $homeSection->is_active) ? 'checked' : '' }}>
                <span class="ml-2 text-sm text-gray-700">Aktifkan Komponen ini (tampil di halaman depan)</span>
            </label>
        </div>

        <div>
            <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded font-bold hover:bg-red-700 transition">
                Perbarui Komponen
            </button>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelector = document.getElementById('type_selector');
        const fieldGroups = document.querySelectorAll('.field-group');

        function updateFields() {
            const selectedType = typeSelector.value;
            
            fieldGroups.forEach(group => {
                const showFor = group.getAttribute('data-show-for').split(',');
                if (selectedType && showFor.includes(selectedType)) {
                    group.style.display = group.tagName === 'DIV' && group.classList.contains('grid') ? 'grid' : 'block';
                } else {
                    group.style.display = 'none';
                }
            });
        }

        typeSelector.addEventListener('change', updateFields);
        updateFields(); // Run on load

        // Initialize CKEditor
        if(document.querySelector('#content_editor')) {
            ClassicEditor
                .create(document.querySelector('#content_editor'))
                .catch(error => {
                    console.error(error);
                });
        }
    });
</script>
@endpush
