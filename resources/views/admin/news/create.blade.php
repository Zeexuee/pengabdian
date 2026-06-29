@extends('layouts.admin')

@section('page_title', 'Tambah Berita Baru')

@section('content')
<div class="max-w-4xl">
    <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        <div>
            <label for="title" class="block text-gray-700 font-semibold mb-2">Judul Berita</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" 
                   class="w-full px-4 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror" 
                   placeholder="Masukkan judul berita">
            @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="content" class="block text-gray-700 font-semibold mb-2">Konten</label>
            <textarea name="content" id="content" rows="8" 
                      class="w-full px-4 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('content') border-red-500 @enderror" 
                      placeholder="Tulis isi berita di sini...">{{ old('content') }}</textarea>
            @error('content')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="thumbnail" class="block text-gray-700 font-semibold mb-2">Thumbnail (Gambar)</label>
            <input type="file" name="thumbnail" id="thumbnail" accept="image/*" 
                   class="w-full px-4 py-2 bg-white border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('thumbnail') border-red-500 @enderror">
            @error('thumbnail')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="status" class="block text-gray-700 font-semibold mb-2">Status</label>
            <select name="status" id="status" 
                    class="w-full px-4 py-2 bg-white border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror">
                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
            </select>
            @error('status')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end space-x-4 pt-4">
            <a href="{{ route('admin.news.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 font-semibold transition">Batal</a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-semibold transition">Simpan Berita</button>
        </div>
    </form>
</div>
@endsection
